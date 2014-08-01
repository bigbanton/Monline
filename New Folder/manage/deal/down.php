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

need_auth('market');

$id = abs(intval($_GET['id']));

$deals = Table::Fetch('deals', $id);

if ($deals['delivery'] == 'express') {
    
    $oc = array(
        
        'state' => 'pay',
        
         'deals_id' => $id,
        
        );
    
     $orders = DB::LimitQuery('order', array('condition' => $oc));
    
     $kn = array(
        
        'realname' => 'Name',
        
         'mobile' => 'Handphone',
        
         'address' => 'Address',
        
        );
    
     $name = "deals_{$id}_" . date('Ymd');
    
     down_xls($orders, $kn, $name);
    
    } 

else {
    
    $cc = array(
        
        'deals_id' => $id,
        
        );
    
     $coupons = DB::LimitQuery('coupon', array('condition' => $cc));
    
     $users = Table::Fetch('user', Utility::GetColumn($coupons, 'user_id'));
    
     $kn = array(
        
        'email' => 'Email',
        
         'mobile' => 'Handphone',
        
         'id' => "{$INI['system']['couponname']} Code",
        
         'secret' => "{$INI['system']['couponname']} password",
        
        );
    
    
    
     $ecs = array();
    
     foreach($coupons As $o) {
        
        $u = $users[$o['user_id']];
        
         $ecs[] = array(
            
            'id' => $o['id'],
            
             'secret' => $o['secret'],
            
             'mobile' => $u['mobile'],
            
             'email' => $u['email'],
            
            );
        
         } 
    
    $name = "deals_{$id}_" . date('Ymd');
    
     down_xls($ecs, $kn, $name);
    
    } 

