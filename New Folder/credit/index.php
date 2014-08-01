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

need_login();

$condition = array('user_id' => $login_user['id'],);

$count = Table::Count('flow', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$flows = DB::LimitQuery('flow', array(
        
        'condition' => $condition,
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
         'order' => 'ORDER BY id DESC',
        
        ));

$detail_ids = Utility::GetColumn($flows, 'detail_id');

$deals = Table::Fetch('deals', $detail_ids);

$users = Table::Fetch('user', $detail_ids);

$coupons = Table::Fetch('coupon', $detail_ids);

$action = array(
    
    'buy' => 'Buy',
    
     'invite' => 'Invite',
    
     'store' => 'Topup',
    
     'coupon' => 'Rebate',
    
     'refund' => 'Refund',
    
    );

include template('credit_index');

