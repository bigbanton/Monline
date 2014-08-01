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

ob_start();

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

$ob_content = ob_get_clean();

need_login();

$total_money = abs(intval($_POST['money']));

$action = strval($_POST['action']);

if (!$total_money && $action != 'redirect') {
    
    
    
    Session::Set('error', TEXT_EN_TOPUP_VALUE_CANNNOT_BE_LESS_THAN_EN . ' ' . $currency . '1');
    
    
    
     Utility::Redirect(BASE_REF . '/credit/charge.php');
    
    
    
    } 

$order['service'] = $_POST['paytype'];

$title = "Add funds: {$currency}{$total_money}  ({$login_user['email']})";

$now = time();

$randno = rand(1000, 9999);

/**
 * credit pay
 */

if ($_POST['action'] == 'redirect') {
    
    
    
    Utility::Redirect($_POST['reqUrl']);
    
    
    
    } 

elseif ($_POST['paytype'] == 'paypal') {
    
    
    
    
    
    
    
    $_input_charset = 'utf-8';
    
    
    
     $partner = $INI['paypal']['mid'];
    
    
    
     $security_code = $INI['paypal']['sec'];
    
    
    
     $seller_acc = $INI['paypal']['acc'];
    
    
    
    
    
    
    
     $sign_type = 'MD5';
    
    
    
     $out_trade_no = "charge-{$login_user_id}-{$now}-{$randno}";
    
    
    
    
    
    
    
    
    
     $return_url = $INI['system']['wwwprefix'] . '/account/order/paypal_success.php';
    
     $notify_url = $INI['system']['wwwprefix'] . '/account/order/paypal_ipn.php';
    
     $show_url = $INI['system']['wwwprefix'] . "/credit/index.php";
    
    
    
    
    
    
    
    
    
     $subject = $title;
    
    
    
     $body = $show_url;
    
    
    
     $quantity = 1;
    
    
    
     $mydef_currency = $INI['system']['currcode'];
    
    
    
    
    
     $paypal = new Paypal();
    
    
    
     $paypal->add_field('business', $seller_acc);
    
    
    
     $paypal->add_field('notify_url', $notify_url);
    
    
    
     $paypal->add_field('return', $return_url);
    
    
    
     $paypal->add_field('item_name', $subject);
    
    
    
     $paypal->add_field('item_number', $out_trade_no);
    
    
    
     $paypal->add_field('currency_code', $INI['system']['currcode']);
    
    
    
     $paypal->add_field('amount', $total_money);
    
    
    
     $paypal->add_field('txn_id', $out_trade_no);
    
    
    
    
    
    
    
     $sign = $paypal->submit_verify();
    
    
    
     include template('order_charge');
    
    
    
    } 

elseif ($_POST['paytype'] == 'authorizenet') {
    
    
    
    
    
    
    
    $_input_charset = 'utf-8';
    
    
    
     $security_code = $INI['authorizenet']['sec'];
    
    
    
     $seller_acc = $INI['authorizenet']['acc'];
    
    
    
     $sign_type = 'MD5';
    
    
    
     $out_trade_no = "charge-{$login_user_id}-{$now}-{$randno}";
    
    
    
     $subject = $title;
    
    
    
     $quantity = 1;
    
    
    
     $rand = rand(20000, 29999);
    
    
    
    
    
    
    
     // Include the Authoize.Net library
    
    
    include_once("gatewayapi/inc_gatewayapi.php");
    
    
    
    include template('order_auth');
    
    
    
    } 

elseif ($_POST['paytype'] == 'pagseguro') {
    
    
    
    
    
    
    
    $_input_charset = 'utf-8';
    
    
    
     $security_code = $INI['pagseguro']['sec'];
    
    
    
     $seller_acc = $INI['pagseguro']['acc'];
    
    
    
     $out_trade_no = "charge-{$login_user_id}-{$now}-{$randno}";
    
    
    
     $subject = $title;
    
    
    
     $quantity = 1;
    
    
    
    
    
    
    
    // Include the Pagseguro library
    
    
    $gatewayUrl = 'https://pagseguro.uol.com.br/checkout/checkout.jhtml';
    
    
    
    $pgs = array(
        
        
        
        'email_cobranca' => $seller_acc,
        
        
        
         'tipo_frete' => 'EN',
        
        
        
         'ref_transacao' => $out_trade_no,
        
        
        
         'tipo' => 'CP',
        
        
        
         'moeda' => $INI['system']['currcode'],
        
        
        
         'item_id_1' => '999',
        
        
        
         'item_descr_1' => $subject,
        
        
        
         'item_quant_1' => $quantity,
        
        
        
         'item_valor_1' => ($total_money * 100),
        
        
        
         'item_frete_1' => '0',
        
        
        
         'item_peso_1' => '0',
        
        
        
        );
    
    
    
    
    
    
    
    
    
    
    
     echo "<html>\n";
    
    
    
     echo "<head><title>Processing Payment...</title></head>\n";
    
    
    
     echo "<body onLoad=\"document.forms['gateway_form'].submit();\"><br/><br/>\n";
    
    
    
     echo "<p style=\"text-align:center;width:100%;\"><img src=\"/themes/css/default/_pagseguro.png\" /></p><p style=\"text-align:center;width:100%;\">";
    
    
    
     echo " </p>\n";
    
    
    
     echo "<p style=\"width:100%;text-align:center;\"><br/><img src=\"/themes/css/default/loading42.gif\" alt=\"Please wait..\"</p>";
    
    
    
     echo "<form method=\"POST\" name=\"gateway_form\" ";
    
    
    
     echo "action=\"" . $gatewayUrl . "\">\n";
    
    
    
    
    
    
    
     foreach ($pgs as $name => $value)
    
    
    
     {
        
        
        
        echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
        
        
        
         } 
    
    
    
    
    
    
    
    
    
    
    
    echo "<p style=\"text-align:center;\"><br/>";
    
    
    
     echo __(TEXT_EN_NOT_AUTOMATICALLY_REDIRECTED_EN);
    
    
    
     echo "...";
    
    
    
     echo "<br/><br/>\n";
    
    
    
     echo "<input type=\"submit\" value=\"Click Here\"></p>\n";
    
    
    
    
    
    
    
     echo "</form>\n";
    
    
    
     echo "</body></html>\n";
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    } 

else {
    
    
    
    Utility::Redirect(BASE_REF . "/credit/index.php");
    
    
    
    } 

