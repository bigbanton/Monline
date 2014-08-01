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
$usage = array('Y' => 'Used', 'N' => 'Unused');

$condition = array();

/**
 * filter
 */

if (strval($_GET['pid']) !== '') {
    
    $pid = abs(intval($_GET['pid']));
    
     $condition['partner_id'] = $pid;
    
    } 

if (strval($_GET['code'])) {
    
    $code = strval($_GET['code']);
    
     $condition[] = "code LIKE '%" . mysql_escape_string($code) . "%'";
    
    } 

if (strval($_GET['state'])) {
    
    $state = strval($_GET['state']);
    
     $condition['consume'] = $state;
    
    } 

if (strval($_GET['tid']) !== '') {
    
    $tid = abs(intval($_GET['tid']));
    
     $state = 'Y';
    $pid = '';
    $code = '';
    
     $condition = array();
    
     $condition['deals_id'] = $tid;
    
    } 

/**
 * end
 */

$count = Table::Count('card', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 50);

if (strval($_GET['download'])) {
    $offset = 0;
    $pagesize = 100000;
} 

$cards = DB::LimitQuery('card', array(
        
        'condition' => $condition,
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
         'order' => 'ORDER BY begin_time DESC, end_time DESC',
        
        ));

$partner_ids = Utility::GetColumn($cards, 'partner_id');

$partners = Table::Fetch('partner', $partner_ids);

if (strval($_GET['download'])) {
    
    $name = "card_{$state}_" . date('Ymd');
    
     $kn = array(
        
        'id' => 'ID',
        
         'credit' => 'Total amount',
        
         'card' => 'CardAmount',
        
        );
    
     $order_ids = array_unique(Utility::GetColumn($cards, 'order_id'));
    
     $orders = Table::Fetch('order', $order_ids);
    
     foreach($cards AS $cid => $one) {
        
        $one['id'] = '#' . $one['id'];
        
         $one['card'] = moneyit($orders[$one['order_id']]['card']);
        
         $cards[$cid] = $one;
        
         } 
    
    down_xls($cards, $kn, $name);
    
    } 

include template('manage_coupon_card');

