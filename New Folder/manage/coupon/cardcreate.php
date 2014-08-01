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

need_manager();
$module = 'coupons';
if (is_post()) {
    
    $card = $_POST;
    
    
    
     $card['quantity'] = abs(intval($card['quantity']));
    
     $card['money'] = abs(intval($card['money']));
    
     $card['partner_id'] = abs(intval($card['partner_id']));
    
     $card['begin_time'] = strtotime($card['begin_time']);
    
     $card['end_time'] = strtotime($card['end_time']);
    
    
    
     $error = array();
    
     if ($card['money'] < 1) {
        
        $error[] = "Voucher can not less than 1 dollar";
        
         } 
    
    if ($card['quantity'] < 1 || $card['quantity'] > 1000) {
        
        $error[] = "1000 Voucher can be generated each time";
        
         } 
    
    $today = strtotime(date('Y-m-d'));
    
     if ($card['begin_time'] < $today) {
        
        $error[] = "Start data must earlier than Stop";
        
         } 
    
    elseif ($card['end_time'] < $card['begin_time']) {
        
        $error[] = "End time should not earlier than start time.";
        
         } 
    
    if (!$error && ZCard::CardCreate($card)) {
        
        Session::Set('notice', "{$card['quantity']} coupon created");
        
         Utility::Redirect(BASE_REF . '/manage/coupon/cardcreate.php');
        
         } 
    
    $error = join("<br />", $error);
    
     Session::Set('error', $error);
    
    } 

else {
    
    $card = array(
        
        'begin_time' => time(),
        
         'end_time' => strtotime('+3 months'),
        
         'quantity' => 10,
        
         'money' => 10,
        
         'code' => date('Ymd') . '_GM',
        
        );
    
    } 

include template('manage_coupon_cardcreate');

