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

if ($_POST) {
    
    $deals_id = abs(intval($_POST['deals_id']));
    
     $consume = $_POST['consume'];
    
     if (!$deals_id || !$consume) die('-ERR ERR_NO_DATA');
    
    
    
     $condition = array(
        
        'deals_id' => $deals_id,
        
         'consume' => $consume,
        
        );
    
    
    
     $coupons = DB::LimitQuery('coupon', array(
            
            'condition' => $condition,
            
            ));
    
    
    
     if (!$coupons) die('-ERR ERR_NO_DATA');
    
     $deals = Table::Fetch('deals', $deals_id);
    
     $name = 'coupon_' . date('Ymd');
    
     $kn = array(
        
        'consume' => 'Status',
        
         'id' => 'ID',
        
         'secret' => 'Password',
        
         'date' => 'Valid',
        
        );
    
    
    
     $consume = array(
        
        'Y' => 'Used',
        
         'N' => 'Unused',
        
        );
    
     $ecoupons = array();
    
     foreach($coupons AS $one) {
        
        $one['id'] = "#{$one['id']}";
        
         $one['consume'] = $consume[$one['consume']];
        
         $one['date'] = date('Y-m-d', $one['expire_time']);
        
         $ecoupons[] = $one;
        
         } 
    
    down_xls($ecoupons, $kn, $name);
    
    } 

include template('manage_market_downcoupon');

