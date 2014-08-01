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

$partner_id = abs(intval($_SESSION['partner_id']));

$login_partner = Table::Fetch('partner', $partner_id);

$title = strval($_GET['title']);

$condition = $t_con = array(
    
    'partner_id' => $partner_id,
    
    );

if ($title) {
    
    $t_con[] = "title like '%" . mysql_escape_string($title) . "%'";
    
     $deals = DB::LimitQuery('deals', array(
            
            'condition' => $t_con,
            
            ));
    
     $deals_ids = Utility::GetColumn($deals, 'id');
    
     if ($deals_ids) {
        
        $condition['deals_id'] = $deals_ids;
        
         } else {
        $title = null;
    } 
    
    } 

$count = Table::Count('coupon', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$coupons = DB::LimitQuery('coupon', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$deals_ids = Utility::GetColumn($coupons, 'deals_id');

$deals = Table::Fetch('deals', $deals_ids);

$user_ids = Utility::GetColumn($coupons, 'user_id');

$users = Table::Fetch('user', $user_ids);

include template('global_coupon');

