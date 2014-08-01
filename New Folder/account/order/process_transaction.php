<?php

/**
 * //License information must not be removed.
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @Architecture ### Secured  ###
 * @Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @License EULA License http://www.gripsell.com
 * @Author $Author: gripsell $
 * @Version $Version: 5.3.3 $
 * @Last Revision $Date: 2013-21-05 00:00:00 +0530 (Tue, 21 May 2013) $
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
include(dirname(dirname(dirname(__FILE__))) . '/config.php');
include_once("gatewayapi/inc_gatewayapi.php");

 $array1 = array(",", ":", ";");
 $array2 = array(" ", " ", " ");
 $strVariables = str_replace($array1, $array2, $_REQUEST);

 $transaction = new GatewayTransaction($strVariables, $_SERVER['REMOTE_ADDR']);

 list($trans_success, $responseString, $errorCode) = $transaction->ProcessTransaction();

 if ($trans_success)
 {
    
    $arr = explode(",", $responseString);
     $response = new GatewayResponse($responseString, ",");
     if ($GatewaySettings['MD5Hash']
         && !$response->VerifyMD5Hash($GatewaySettings['MD5Hash'],
             $transaction->username,
             $transaction->amount))
         {
        header("Location: " . $GatewaySettings['PaymentDeniedPage'] . "?gateway_error=" . rawurlencode($transaction->GetErrorString("INVALID_MD5HASH")));
         exit();
         } 
    
    if ($response->IsApproved())
         {
        $out_trade_no = $arr[68];
         $total_fee = $response->GetField("Amount");
         @list($_, $user_id, $create_time, $_) = explode('-', $out_trade_no, 4);
        
        if ($_ == 'charge') {
            ZFlow::CreateFromCharge($total_fee, $user_id, $create_time, 'Authorize.Net');
             Session::Set('notice', TEXT_EN_ACCOUNT_RECHARGED_SUCCESSFULLY_EN);
             Utility::Redirect(BASE_REF . "/credit/index.php");
            } 
        @list($_, $order_id, $city_id, $_, $amm, $charfor, $quantity) = explode('-', $out_trade_no, 7);
        
         $order = Table::Fetch('order', $order_id);
         if ($order['state'] == 'unpay') {
            $table = new Table('order');
             $table->SetPk('id', $order_id);
             $table->pay_id = $out_trade_no;
             $table->money = $total_fee;
             $table->state = 'pay';
             $flag = $table->update(array('state', 'pay_id', 'money'));
            
             if ($flag) {
                $table = new Table('pay');
                 $table->id = $out_trade_no;
                 $table->order_id = $order_id;
                 $table->money = $total_fee;
                 $table->currency = $mydef_currency;
                 $table->bank = 'Authorize.Net';
                 $table->service = 'Authorize.Net';
                 $table->create_time = time();
                 $table->insert(array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank'));
                 Zdeals::BuyOne($order);
                 } 
            } 
        
        include ('do_charity.php');
        
         Session::Set('notice', TEXT_EN_YOUR_PAYMENT_HAS_BEEN_PROCESSED_SUCCESSFULLY_EN);
        
         Utility::Redirect(BASE_REF . "/account/order/index.php");
        
         } 
    else
        
         Session::Set('error', TEXT_EN_ERROR_IN_PROCESSING_THE_PAYMENT_EN . $response->GetField("ResponseReasonText"));
    
     Utility::Redirect(BASE_REF . "/account/order/index.php");
    
    
     } 
else
    
     Session::Set('error', TEXT_EN_ERROR_IN_PROCESSING_THE_PAYMENT_EN . $transaction->GetErrorString($errorCode));

 Utility::Redirect(BASE_REF . "/account/order/index.php");

?>