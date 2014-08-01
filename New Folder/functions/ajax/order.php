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

$action = strval($_GET['action']);
$id = $order_id = abs(intval($_GET['id']));

if ($action == 'update') {
    $order = Table::Fetch('order', $order_id);
    if ($login_user['money'] < $order['origin']) {
        echo moneyit($order['origin'] - $login_user['money']);
        } else {
        echo 'hide';
        } 
    
    } else {
    
    $charge = strval($_GET['id']) == 'charge';
    
    $id = $order_id = ($charge ? 'charge' : $id);
    
    
    
    if (!$order_id && !$charge) {
        
        json('Order does not exist', 'alert');
        
        } 
    
    
    
    if ($action == 'dialog') {
        
        // $html = render('tsg_dialog_order');
        // json($html, 'dialog');
        } 
    
    elseif ($action == 'cardcode') {
        
        $cid = strval($_GET['cid']);
        
         $order = Table::Fetch('order', $order_id);
        
         if (!$order) json('Order does not exist', 'alert');
        
         $ret = ZCard::UseCard($order, $cid);
        
         if (true === $ret) {
            
            json(array(
                    
                    array('data' => "Coupon used OK", 'type' => 'alert'),
                    
                     array('data' => null, 'type' => 'refresh'),
                    
                    ), 'mix');
            
             } 
        
        $error = ZCard::Explain($ret);
        
         json($error, 'alert');
        
        } 
    
    } 
