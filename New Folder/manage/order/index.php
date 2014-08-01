<?php

/**
 * //License information must not be removed.
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
$module = 'orders';
$t_con = array(
    'begin_time < ' . time(),
     'end_time > ' . time(),
    );
$deals = DB::LimitQuery('deals', array('condition' => $t_con));
$t_id = Utility::GetColumn($deals, 'id');

$condition = array(
    // 'deals_id' => $t_id,
    'deals_id > 0',
    );

/**
 * filter
 */
$uemail = strval($_GET['uemail']);
if ($uemail) {
    $uuser = Table::Fetch('user', $uemail, 'email');
     if ($uuser) $condition['user_id'] = $uuser['id'];
     else $uemail = null;
    } 
$deals_id = abs(intval($_GET['deals_id']));
if ($deals_id && in_array($deals_id, $t_id)) {
    $condition['deals_id'] = $deals_id;
    } else {
    $deals_id = null;
} 

/**
 * end fiter
 */

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$orders = DB::LimitQuery('order', array(
        'condition' => $condition,
         'order' => 'ORDER BY id DESC',
         'size' => $pagesize,
         'offset' => $offset,
        ));

$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$deals_ids = Utility::GetColumn($orders, 'deals_id');
foreach($orders as $order) {
    $table = $order['isinsta'] == 1?'insta':'deals';
    $deals[$order['deals_id']][$order['isinsta']] = Table::Fetch($table, $order['deals_id']);
    } 

include template('manage_order_index');
