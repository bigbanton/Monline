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

$daytime = strtotime(date('Y-m-d'));

$condition = array(
    
    'user_id' => $login_user_id,
    
     'consume' => 'N',
    
     "expire_time < {$daytime}",
    
    );

$count = Table::Count('coupon', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$coupons = DB::LimitQuery('coupon', array(
        
        'condition' => $condition,
        
         'coupon' => 'ORDER BY create_time DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$deals_ids = Utility::GetColumn($coupons, 'deals_id');

$deals = Table::Fetch('deals', $deals_ids);

include template('coupon_expire');

