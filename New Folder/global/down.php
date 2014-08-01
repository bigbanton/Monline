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

require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();

need_partner();

$id = abs(intval($_GET['id']));

$partner_id = abs(intval($_SESSION['partner_id']));

$login_partner = Table::Fetch('partner', $partner_id);

$deals = Table::Fetch('deals', $id);

if ($deals['partner_id'] != $partner_id) {
    
    Session::Set('error', TEXT_EN_NO_DATA_ACCESS_PREMISSION_EN);
    
     Utility::Redirect(BASE_REF . '/global/index.php');
    
    } 

if ($deals['delivery'] == 'express') {
    
    $oc = array('state' => 'pay');
    
     $orders = DB::LimitQuery('order', array('condition' => $oc));
    
     $xls[] = "Name\tTel\tAddr";
    
     foreach($orders As $o) {
        
        $xls[] = "{$o['realname']}\t'{$o['mobile']}\t{$o['address']}";
        
         } 
    
    $xls = join("\n", $xls);
    
     header('Content-Disposition: attachment; filename="deals' . $id . '.xls"');
    
     die(mb_convert_encoding($xls, 'UTF-8', 'UTF-8'));
    
    } 

else {
    
    $cc = array(
        
        'deals_id' => $id,
        
        );
    
     $coupons = DB::LimitQuery('coupon', array('condition' => $cc));
    
     $users = Table::Fetch('user', Utility::GetColumn($coupons, 'user_id'));
    
    
    
     $kn = array(
        
        'email' => 'Email',
        
         'mobile' => 'Cellphone',
        
         'id' => $INI['system']['couponname'] . "ID",
        
        );
    
     if (abs(intval($INI['system']['partnerdown']))) {
        
        $kn['secret'] = 'pay password';
        
         } 
    
    foreach($coupons As $kid => $o) {
        
        $u = $users[$o['user_id']];
        
         $o['email'] = $u['email'];
        
         $o['mobile'] = $u['mobile'];
        
         $coupons[$kid] = $o;
        
         } 
    
    
    
    $name = "dealscoupon_{$id}";
    
     down_xls($coupons, $kn, $name);
    
    } 

