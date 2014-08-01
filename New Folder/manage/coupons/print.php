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

require ('qrcode.class.php');

$qrclass = &New QRClass;

$id = strval($_GET['id']);

$coupon = Table::Fetch('coupon', $id);

if (!$coupon) {
    
    Session::Set('error', "{$INI['system']['couponname']} does not exist");
    
     Utility::Redirect(BASE_REF . '/manage/coupons/index.php');
    
    } 

$barcode = $qrclass->text($coupon['id'], 150, 150);

if ($coupon['user_id'] != $login_user_id) {
    
    Session::Set('error', "Order {$INI['system']['couponname']} is not yours");
    
     Utility::Redirect(BASE_REF . '/manage/coupons/index.php');
    
    } 

$partner = Table::Fetch('partner', $coupon['partner_id']);
if ($coupon['isinsta'] == 1) {
    $deals = Table::Fetch('insta_details', $coupon['deals_id'], 'deal_id');
    
    } else {
    $deals = Table::Fetch('deals', $coupon['deals_id']);
    } 

include template('coupon_print');

