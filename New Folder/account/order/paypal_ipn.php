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

// Include the paypal library
include_once ('Paypal.php');

// Create an instance of the paypal library
$myPaypal = new Paypal();

// Log the IPN results
$myPaypal->ipnLog = true;

// Enable test mode if needed
// $myPaypal->enableTestMode();
$out_trade_no = $_REQUEST['item_number'];
// Check validity and write down it
if (strpos($out_trade_no, 'sandbox')) {
    if (true)
     {
        if (true)
         {
            
            $out_trade_no = $_REQUEST['item_number'];
             $total_fee = $_REQUEST['mc_gross'];
            
             @list($_, $user_id, $create_time, $_) = explode('-', $out_trade_no, 4);
            
            if ($_ == 'charge') {
                ZFlow::CreateFromCharge($total_fee, $user_id, $create_time, 'Authorize.Net');
                 Session::Set('notice', TEXT_EN_ACCOUNT_RECHARGED_SUCCESSFULLY_EN);
                 Utility::Redirect(BASE_REF . "/credit/index.php");
                } 
            @list($_, $order_id, $city_id, $_, $amm, $charfor, $quantity) = explode('-', $out_trade_no, 7);
            
            
             $order = Table::Fetch('order', $order_id);
             if ($order['state'] == 'unpay') {
                // 1
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
                     $table->bank = 'PayPal';
                     $table->service = 'PayPal';
                     $table->create_time = time();
                     $table->insert(array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank'));
                    
                     // update team,user,order,flow state//
                    Zdeals::BuyOne($order);
                     } 
                } 
            
            echo "success";
             include ('do_charity.php');
             } 
        else
             {
            
            echo "fail";
            
             } 
        } 
    } else {
    
    if ($myPaypal->validateIpn())
         {
        if ($myPaypal->ipnData['payment_status'] == 'Completed')
         {
            
            $out_trade_no = $myPaypal->ipnData['item_number'];
             $total_fee = $myPaypal->ipnData['payment_gross'];
            
             @list($_, $user_id, $create_time, $_) = explode('-', $out_trade_no, 4);
            
            if ($_ == 'charge') {
                ZFlow::CreateFromCharge($total_fee, $user_id, $create_time, 'Authorize.Net');
                 Session::Set('notice', TEXT_EN_ACCOUNT_RECHARGED_SUCCESSFULLY_EN);
                 Utility::Redirect(BASE_REF . "/credit/index.php");
                } 
            @list($_, $order_id, $city_id, $_, $amm, $charfor, $quantity) = explode('-', $out_trade_no, 7);
            
            
             $order = Table::Fetch('order', $order_id);
             if ($order['state'] == 'unpay') {
                // 1
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
                     $table->bank = 'PayPal';
                     $table->service = 'PayPal';
                     $table->create_time = time();
                     $table->insert(array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank'));
                    
                     // update team,user,order,flow state//
                    Zdeals::BuyOne($order);
                     } 
                } 
            
            echo "success";
             include ('do_charity.php');
             } 
        else
             {
            
            echo "fail";
            
             } 
        } 
    } 
