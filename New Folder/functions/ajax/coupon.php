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

$action = strval($_GET['action']);

$cid = strval($_GET['id']);

$sec = strval($_GET['secret']);

if ($action == 'dialog') {
    
    $html = render('tsg_dialog_coupon');
    
     json($html, 'dialog');
    
    } 

else if ($action == 'query') {
    
    $coupon = Table::FetchForce('coupon', $cid);
    
     $partner = Table::Fetch('partner', $coupon['partner_id']);
    
     $deals = Table::Fetch('deals', $coupon['deals_id']);
    
     $e = date('Y-m-d', $deals['expire_time']);
    
    
    
     if (!$coupon) {
        
        $v[] = "#{$cid}&nbsp;Invalid";
        
         } else if ($coupon['consume'] == 'Y') {
        
        $v[] = $INI['system']['couponname'] . 'Invalid';
        
         $v[] = 'Used on: ' . date('Y-m-d H:i:s', $coupon['consume_time']);
        
         } else if ($coupon['expire_time'] < strtotime(date('Y-m-d'))) {
        
        $v[] = "#{$cid}&nbsp; is expired";
        
         $v[] = 'Valid till: ' . date('Y-m-d', $coupon['consume_time']);
        
         } else {
        
        $v[] = "#{$cid}&nbsp;valid";
        
         $v[] = "{$deals['title']}";
        
         $v[] = "Valid till &nbsp;{$e}";
        
         } 
    
    $v = join('<br/>', $v);
    
     $d = array(
        
        'html' => $v,
        
         'id' => 'coupon-dialog-display-id',
        
        );
    
     json($d, 'updater');
    
    } 

else if ($action == 'consume') {
    
    $coupon = Table::FetchForce('coupon', $cid);
    
     $partner = Table::Fetch('partner', $coupon['partner_id']);
    
     $deals = Table::Fetch('deals', $coupon['deals_id']);
    
    
    
     if (!$coupon) {
        
        $v[] = "#{$cid}&nbsp;Invalid";
        
         $v[] = 'Failed';
        
         } 
    
    else if ($coupon['secret'] != $sec) {
        
        $v[] = $INI['system']['couponname'] . 'Invalid Code';
        
         $v[] = 'Failed';
        
         } else if ($coupon['expire_time'] < strtotime(date('Y-m-d'))) {
        
        $v[] = "#{$cid}&nbsp;is Expired";
        
         $v[] = 'Valid Till: ' . date('Y-m-d', $coupon['consume_time']);
        
         $v[] = 'Failed';
        
         } else if ($coupon['consume'] == 'Y') {
        
        $v[] = "#{$cid}&nbsp;is Used";
        
         $v[] = 'Buy at: ' . date('Y-m-d H:i:s', $coupon['consume_time']);
        
         $v[] = 'Failed';
        
         } else {
        
        ZCoupon::Consume($coupon);
        
         // credit to user'money'
        $tip = ($coupon['credit'] > 0) ? " Get {$coupon['credit']} dollars rebate" : '';
        
         $v[] = $INI['system']['couponname'] . 'Valid';
        
         $v[] = 'Buy at: ' . date('Y-m-d H:i:s', time());
        
         $v[] = 'Buy successfully' . $tip;
        
         } 
    
    $v = join('<br/>', $v);
    
     $d = array(
        
        'html' => $v,
        
         'id' => 'coupon-dialog-display-id',
        
        );
    
     json($d, 'updater');
    
    } 

else if ($action == 'sms') {
    
    $coupon = Table::Fetch('coupon', $cid);
    
     if ($coupon['sms'] >= 5 && !is_manager()) {
        
        json('SMS sending max 5 times', 'alert');
        
         } 
    
    if (!$coupon || !is_login() || $coupon['user_id'] != ZLogin::GetLoginId()) {
        
        json('Illegal download', 'alert');
        
         } 
    
    $flag = sms_coupon($coupon);
    
     if ($flag === true) {
        
        json('SMS is sent, please check it', 'alert');
        
         } else if (is_string($flag)) {
        
        json($flag, 'alert');
        
         } 
    
    json("Sending SMS failed, error code: {$code}", 'alert');
    
    } 

