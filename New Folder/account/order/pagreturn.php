<?php

/**
 * //License information must not be removed.
 * 
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

define('TOKEN', $INI['pagseguro']['mid']);

 $timeout = 20; // Timeout em segundos

 $data = 'Comando=validar&Token=' . TOKEN;

 foreach ($_POST as $key => $value) {
    
    // $valued    = $this->clearStr($value);
    $data .= "&$key=$value";
    
     } 

// private function clearStr($str) {
// if (!get_magic_quotes_gpc()) {
// $str = addslashes($str);
// }
// return $str;
// }

$curl = curl_init();

 curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");

 curl_setopt($curl, CURLOPT_POST, true);

 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

 curl_setopt($curl, CURLOPT_HEADER, false);

 curl_setopt($curl, CURLOPT_TIMEOUT, timeout);

 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

 $result = trim(curl_exec($curl));

 curl_close($curl);

 // $this->logit($result);

// Timestamp
$text = $result . ' ----' . '[' . date('m/d/Y g:i A') . '] - ';

 // Log the POST variables
$text .= "IPN POST Vars from gateway:\n";

 foreach ($_POST as $key => $value)

 {
    
    $text .= "$key=$value, \n";
    
     } 

// POST recebido, indica que é a requisição do NPI
$status = $_POST['StatusTransacao'];

 $transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';

 if ($result == 'VERIFICADO') {
    
    
    
    // for ( $counter = 0; $counter <= count($arr); $counter += 1) {
    // echo '  '.$counter.': '.$arr[$counter];
    // }
    // exit();
    if ($status === 'Aprovado') {
        
        $text .= "result=verified \n";
        
         $out_trade_no = $_POST['Referencia'];
        
         $total_fee = abs(intval($_POST['ProdValor_1']));
        
         @list($_, $user_id, $create_time, $_) = explode('-', $out_trade_no, 4);
        
        
        
         $text .= "fee={$total_fee} \n";
        
         // Add Balance
        
        
        if ($_ == 'charge') {
            
            //  @list ($_, $user_id, $create_time, $_) = explode('-', $out_trade_no, 4);
            ZFlow::CreateFromCharge($total_fee, $user_id, $create_time, 'Pagseguro');
            
             Session::Set('notice', TEXT_EN_ACCOUNT_RECHARGED_SUCCESSFULLY_EN);
            
             Utility::Redirect(BASE_REF . "/credit/index.php");
            
             } 
        
        
        
        // Live Purchase
        
        
        @list($_, $order_id, $city_id, $_, $amm, $charfor, $quantity) = explode('-', $out_trade_no, 7);
        
        
        
         $order = Table::Fetch('order', $order_id);
        
        $text .= "order={$order} \n";
        
        $text .= "qty={$quantity} \n";
        
        $text .= "qty={$order['state']} \n";
        
        
        
         if ($order['state'] == 'unpay') {
            
            // 1
            $table = new Table('order');
            
             $table->SetPk('id', $order_id);
            
             $table->pay_id = $out_trade_no;
            
             $table->money = $total_fee;
            
             $table->state = 'pay';
            
             $flag = $table->update(array('state', 'pay_id', 'money'));
            
            $text .= "flag={$flag} \n";
            
             if ($flag) {
                
                $table = new Table('pay');
                
                 $table->id = $out_trade_no;
                
                 $table->order_id = $order_id;
                
                 $table->money = $total_fee;
                
                 $table->currency = $mydef_currency;
                
                 $table->bank = 'Pagseguro';
                
                 $table->service = 'Pagseguro';
                
                 $table->create_time = time();
                
                 $table->insert(array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank'));
                
                
                
                 // update team,user,order,flow state//
                Zdeals::BuyOne($order);
                
                 } 
            
            } 
        
        
        
        if ($charfor) include ('do_charity.php');
        
        
        
         // Write to log
        // $fp = fopen('pagseguro.log','a');
        // fwrite($fp, $text . "\n\n");
        // fclose($fp);
        
        
        
        
        Session::Set('notice', TEXT_EN_YOUR_PAYMENT_HAS_BEEN_PROCESSED_SUCCESSFULLY_EN);
        
        
        
         } elseif ($status == 'Cancelado') {
        
        
        
        Session::Set('notice', TEXT_EN_YOUR_PAYMENT_HAS_BEEN_PROCESSED_FAILED_EN);
        
        
        
         } else {
        
        
        
        Session::Set('notice', TEXT_EN_YOUR_PAYMENT_HAS_BEEN_PROCESSED_NOT_PROCESSED_EN);
        
        
        
         } 
    
    
    
    } else if ($result == "FALSO") {
    
    
    
    if (Session::Get('notice') != TEXT_EN_YOUR_PAYMENT_HAS_BEEN_PROCESSED_SUCCESSFULLY_EN) Session::Set('error', TEXT_EN_TRANSACTIONS_WAIT_SUCCESS_EN);
    
    
    
     Utility::Redirect(BASE_REF . "/account/order/index.php");
    
    
    
     } else {
    
    
    
    Session::Set('error', ' ' . TEXT_EN_TRANSACTIONS_WAIT_SUCCESS_EN);
    
    
    
     Utility::Redirect(BASE_REF . "/account/order/index.php");
    
    
    
     } 

?>