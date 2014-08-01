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
$module = 'financials';
$actions = array('store', 'charge', 'withdraw', 'cash', 'refund');

($s = strtolower(strval($_GET['s']))) || ($s = 'store');

if (!$s || !in_array($s, $actions)) $s = 'store';

if ('store' == $s) {
    
    $condition = array('action' => 'store',);
    
     $count = Table::Count('flow', $condition);
    
     $summary = Table::Count('flow', $condition, 'money');
    
     list($pagesize, $offset, $pagestring) = pagestring($count, 20);
    
     $flows = DB::LimitQuery('flow', array(
            
            'condition' => $condition,
            
             'order' => 'ORDER BY id DESC',
            
            ));
    
     $user_ids = Utility::GetColumn($flows, 'user_id');
    
     $admin_ids = Utility::GetColumn($flows, 'admin_id');
    
     $users = Table::Fetch('user', array_merge($user_ids, $admin_ids));
    
     include template('manage_finance_store');
    
    } 

elseif ('charge' == $s) {
    
    $condition = array('action' => 'charge',);
    
     $count = Table::Count('flow', $condition);
    
     $summary = Table::Count('flow', $condition, 'money');
    
     list($pagesize, $offset, $pagestring) = pagestring($count, 20);
    
     $flows = DB::LimitQuery('flow', array(
            
            'condition' => $condition,
            
             'order' => 'ORDER BY id DESC',
            
            ));
    
     $user_ids = Utility::GetColumn($flows, 'user_id');
    
     $admin_ids = Utility::GetColumn($flows, 'admin_id');
    
     $users = Table::Fetch('user', array_merge($user_ids, $admin_ids));
    
     $pay_ids = Utility::GetColumn($flows, 'detail_id');
    
     $pays = Table::Fetch('pay', $pay_ids);
    
     include template('manage_finance_charge');
    
    } 

else if ('withdraw' == $s) {
    
    $condition = array('action' => 'withdraw',);
    
     $count = Table::Count('flow', $condition);
    
     $summary = Table::Count('flow', $condition, 'money');
    
     list($pagesize, $offset, $pagestring) = pagestring($count, 20);
    
     $flows = DB::LimitQuery('flow', array(
            
            'condition' => $condition,
            
             'order' => 'ORDER BY id DESC',
            
            ));
    
     $user_ids = Utility::GetColumn($flows, 'user_id');
    
     $admin_ids = Utility::GetColumn($flows, 'admin_id');
    
     $users = Table::Fetch('user', array_merge($user_ids, $admin_ids));
    
     include template('manage_finance_store');
    
    } 

else if ('cash' == $s) {
    
    $condition = array('service' => 'cash', 'state' => 'pay',);
    
     $summary = Table::Count('order', $condition, 'money');
    
     $count = Table::Count('order', $condition);
    
     list($pagesize, $offset, $pagestring) = pagestring($count, 20);
    
     $orders = DB::LimitQuery('order', array(
            
            'condition' => $condition,
            
             'order' => 'ORDER BY id DESC',
            
            ));
    
    
    
     $user_ids = Utility::GetColumn($orders, 'user_id');
    
     $admin_ids = Utility::GetColumn($orders, 'admin_id');
    
     $users = Table::Fetch('user', array_merge($user_ids, $admin_ids));
    
    
    
     $deals_ids = Utility::GetColumn($orders, 'deals_id');
    
     $deals = Table::Fetch('deals', $deals_ids);
    
     include template('manage_finance_cash');
    
    } 

else if ('refund' == $s) {
    
    $condition = array('service' => 'cash', 'state' => 'unpay',);
    
     $summary = Table::Count('order', $condition, 'money');
    
     $count = Table::Count('order', $condition);
    
     list($pagesize, $offset, $pagestring) = pagestring($count, 20);
    
     $orders = DB::LimitQuery('order', array(
            
            'condition' => $condition,
            
             'order' => 'ORDER BY id DESC',
            
            ));
    
    
    
     $user_ids = Utility::GetColumn($orders, 'user_id');
    
     $admin_ids = Utility::GetColumn($orders, 'admin_id');
    
     $users = Table::Fetch('user', array_merge($user_ids, $admin_ids));
    
    
    
     $deals_ids = Utility::GetColumn($orders, 'deals_id');
    
     $deals = Table::Fetch('deals', $deals_ids);
    
     include template('manage_finance_refund');
    
    } 

else Utility::Redirect(BASE_REF . '/manage/finance/index.php');

