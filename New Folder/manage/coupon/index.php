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
$daytime = strtotime(date('Y-m-d'));

$condition = array(
    
    'consume' => 'N',
    
     'expire_time >= ' . $daytime,
    
    );

$count = Table::Count('coupon', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$coupons = DB::LimitQuery('coupon', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY expire_time ASC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$users = Table::Fetch('user', Utility::GetColumn($coupons, 'user_id'));

// $deals = Table::Fetch('deals', Utility::GetColumn($coupons, 'deals_id'));
foreach($coupons as $coupon) {
    $table = $coupon['isinsta'] == 1?'insta':'deals';
    $deals[$coupon['deals_id']] = Table::Fetch($table, $coupon['deals_id']);
    } 

$selector = 'index';

include template('manage_coupon_index');

