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

if (is_post()) {
    
    $order_id = abs(intval($_POST['order_id']));
    
    } else {
    
    $order_id = $id = abs(intval($_GET['id']));
    
    } 

if (!$order_id || !($order = Table::Fetch('order', $order_id))) {
    
    die('Unauthorized Access. Permission Denied');
    
    } 

if (is_post()) {
    
    $uarray = array('service' => strtolower($_POST['paytype']),);
    
     Table::UpdateCache('order', $order_id, $uarray);
    
     $order = Table::Fetch('order', $order_id);
    
     $order['service'] = strtolower($_POST['paytype']);
    
    } 

$dbname = ($order['isinsta'] || $_REQUEST['isinsta']) ? 'insta' : 'deals';

// Define common variables
$amm = $_POST['x_charamm'];

$charfor = $_POST['x_charity'];

$_input_charset = 'utf-8';

$deals = Table::Fetch($dbname, $order['deals_id']);

$randno = rand(1000, 9999);

$total_money = moneyit($order['origin'] - $login_user['money']);

if ($total_money < 0) {
    $total_money = 0;
    $order['service'] = 'credit';
} 

// ACTIVITY LOG
ZLog::Log($login_user_id, 'New Order Placed', 'Order ID:' . $order_id);

 // ACTIVITY LOG

// Check paid order
if ($order['state'] == 'pay') {
    
    if (is_get()) {
        
        $deals1 = Table::Fetch($dbname, $order['deals_id']);
        
         die(include template('order_pay_success'));
        
         } else {
        
        Utility::Redirect(BASE_REF . "/account/order/pay.php?id={$order_id}");
        
         } 
    
    } 

// ===================================================================
// ============================ PAY WITH CREDIT  =====================
// ===================================================================

if ($_POST['service'] == 'credit') {
    
    if ($order['origin'] > $login_user['money']) {
        
        Table::Delete('order', $order_id);
        
         Utility::Redirect(BASE_REF . '/account/order/index.php');
        
         } 
    
    Table::UpdateCache('order', $order_id, array(
            
            'service' => 'credit',
            
             'money' => 0,
            
             'state' => 'pay',
            
             'credit' => $order['origin'],
            
            ));
    
     $order = Table::FetchForce('order', $order_id);
    
     Zdeals::BuyOne($order);
    
     Utility::Redirect(BASE_REF . "/account/order/pay.php?id={$order_id}");
    
    } 

// ===================================================================
// ============================ PAYPAL STD ===========================
// ===================================================================

else if ($order['service'] == 'paypal') {
    
    
    
    
/**
     * credit pay
     */
    
    $credit = moneyit($order['origin'] - $total_money);
    
     if ($order['credit'] != $credit) {
        
        Table::UpdateCache('order', $order_id, array('credit' => $credit,));
        
         } 
    
    
/**
     * end
     */
    
    
    
    
    
    // $service = 'create_direct_pay_by_user'; // what does it mean??
    $partner = $INI['paypal']['mid'];
    
     $security_code = $INI['paypal']['sec'];
    
     $seller_acc = $INI['paypal']['acc'];
    
     $sign_type = 'MD5';
    
     $quantity = $order['quantity'];
    
     if ($INI['paypal']['mod'] == 'https://www.sandbox.paypal.com/cgi-bin/webscr') {
        $out_trade_no = "paypal-{$order['id']}-{$deals['city_id']}-{$randno}-{$amm}-{$charfor}-{$quantity}-sandbox";
         } else {
        $out_trade_no = "paypal-{$order['id']}-{$deals['city_id']}-{$randno}-{$amm}-{$charfor}-{$quantity}-live";
         } 
    
    $return_url = $INI['system']['wwwprefix'] . '/account/order/paypal/return.php';
    
     $notify_url = $INI['system']['wwwprefix'] . '/account/order/paypal/notify.php';
    
     $show_url = $INI['system']['wwwprefix'] . "/deals.php?id={$deals['id']}";
    
     $subject = $deals['title']; //preg_replace('/[\r\n\s]+/','',strip_tags($deals['title']));
    
    
     $body = $show_url;
    
    
    
    
    
    // Include the paypal library
    include_once ('Paypal.php');
    
    
    
    // Create an instance of the paypal library
    $myPaypal = new Paypal();
    
    
    
    $myPaypal->addField('charset', $_input_charset);
    
    
    
    // Specify your paypal email
    $myPaypal->addField('business', $seller_acc);
    
    
    
    // Specify the currency
    $myPaypal->addField('currency_code', $INI['system']['currcode']);
    
    
    
    // Specify the url where paypal will send the user on success/failure
    $myPaypal->addField('return', $INI['system']['wwwprefix'] . '/account/order/paypal_success.php');
    
    $myPaypal->addField('cancel_return', $INI['system']['wwwprefix'] . '/account/order/paypal_failure.php');
    
    
    
    // Specify the url where paypal will send the IPN
    $myPaypal->addField('notify_url', $INI['system']['wwwprefix'] . '/account/order/paypal_ipn.php');
    
    
    
    // Specify the product information
    $myPaypal->addField('item_name', $subject);
    
    $myPaypal->addField('amount', $total_money);
    
    $myPaypal->addField('item_number', $out_trade_no);
    
    
    
    // Specify any custom value
    $myPaypal->addField('out_trade_no', $out_trade_no);
    
    
    
    // Enable test mode if needed
    if ($INI['paypal']['mod'] == 'https://www.sandbox.paypal.com/cgi-bin/webscr') $myPaypal->enableTestMode();
    
    
    
    // Let's start the train!
    echo '<div style="width:500px; margin:0px auto; font-family:verdana, arial; font-size:12px">';
    
    $myPaypal->submitPayment();
    
    echo '</div>';
    
    
    
     // include template('order_pay');
    } 

// ===================================================================
// ========================== AUTHORIZE.NET ==========================
// ===================================================================

else if ($order['service'] == 'authorizenet') {
    
    
    
    
/**
     * credit pay
     */
    
    $credit = moneyit($order['origin'] - $total_money);
    
     if ($order['credit'] != $credit) {
        
        Table::UpdateCache('order', $order_id, array('credit' => $credit,));
        
         } 
    
    
/**
     * end
     */
    
    // $service = 'create_direct_pay_by_user'; // what does it mean??
    $security_code = $INI['authorizenet']['sec'];
    
     $seller_acc = $INI['authorizenet']['acc'];
    
     $sign_type = 'MD5';
    
     $out_trade_no = "authorizenet-{$order['id']}-{$deals['city_id']}-{$randno}-{$amm}-{$charfor}";
    
     $subject = $deals['title'];
    
     $quantity = $order['quantity'];
    
    
    
    // Include the Authoize.Net library
    include_once("gatewayapi/inc_gatewayapi.php");
    
    include template('order_auth');
    
    } 

// ===================================================================
// ============================ PAGSEGURO ============================
// ===================================================================

else if ($order['service'] == 'pagseguro') {
    
    
    
    
/**
     * credit pay
     */
    
    $credit = moneyit($order['origin'] - $total_money);
    
     if ($order['credit'] != $credit) {
        
        Table::UpdateCache('order', $order_id, array('credit' => $credit,));
        
         } 
    
    
/**
     * end
     */
    
    // $service = 'create_direct_pay_by_user'; // what does it mean??
    $security_code = $INI['pagseguro']['sec'];
    
     $seller_acc = $INI['pagseguro']['acc'];
    
     $sign_type = 'MD5';
    
     $quantity = $order['quantity'];
    
     $out_trade_no = "pagseguro-{$order['id']}-{$deals['city_id']}-{$randno}-{$amm}-{$charfor}-{$quantity}";
    
     $subject = $deals['title'];
    
     $total_money = $total_money / $quantity;
    
    
    
    // Include the Pagseguro library
    $gatewayUrl = 'https://pagseguro.uol.com.br/checkout/checkout.jhtml';
    
    $pgs = array(
        
        'email_cobranca' => $seller_acc,
        
         'tipo_frete' => 'EN',
        
         'ref_transacao' => $out_trade_no,
        
         'tipo' => 'CP',
        
         'moeda' => $INI['system']['currcode'],
        
         'item_id_1' => $order['id'],
        
         'item_descr_1' => $subject,
        
         'item_quant_1' => $order['quantity'],
        
         'item_valor_1' => ($total_money * 100),
        
         'item_frete_1' => '0',
        
         'item_peso_1' => '0',
        
         'encoding' => $_input_charset,
        
        );
    
    
    
     echo "<html>\n";
    
     echo "<head><title>Processing Payment...</title>";
    
     echo "<meta http-equiv=\"content-type\" content=\"text/html charset=UTF-8\" />";
    
     echo "</head>\n";
    
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

// ===================================================================
// ============================ CREDIT ORDER =========================
// ===================================================================

else if ($order['service'] == 'credit') {
    
    $total_money = $order['origin'];
    
     die(include template('order_pay'));
    
    } 

else Utility::Redirect(BASE_REF . '/index.php');

