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

need_dealer();
$module='deal';
$now = time();

$selector = $_GET['show'];

if ($selector && $_GET['action'] == 'do') {
    
    switch ($selector) {
    
    case 'approved':
        
         $condition = array(
            
            'system' => 'Y',
            
             "begin_time < $now",
            
             'stage' => array('1-featured', 'approved'),
            
            );
        
         break;
    
     case 'canceled':
        
         $condition = array(
            
            'system' => 'Y',
            
             'stage' => 'canceled',
            
            );
        
         break;
    
     case 'current':
        
         $condition = array(
            
            'system' => 'Y',
            
             "end_time > $now",
            
             "begin_time < {$now}",
            
             'stage' => array('1-featured', 'approved'),
            
            );
        
         break;
    
     case 'draft':
        
         $condition = array(
            
            'system' => 'Y',
            
             // "begin_time < $now",
            'stage' => 'draft',
            
            );
        
         break;
    
     case 'failed':
        
         $condition = array(
            
            'system' => 'Y',
            
             "end_time < $now",
            
             'now_number < min_number',
            
            );
        
         break;
    
     case 'pending':
        
         $condition = array(
            
            'system' => 'Y',
            
             // "begin_time < $now",
            'stage' => 'pending',
            
            );
        
         break;
    
     case 'returned':
        
         $condition = array(
            
            'system' => 'Y',
            
             // "begin_time < $now",
            'stage' => 'returned',
            
            );
        
         break;
    
     case 'tipped':
        
         $condition = array(
            
            'system' => 'Y',
            
             "begin_time < $now",
            
             'now_number >= min_number',
            
            );
        
         break;
    
     case 'all':
        
         $condition = array(
            
            'system' => 'Y',
            
            );
        
         break;
    
     default:
        
         $condition = array(
            
            'system' => 'Y',
            
             // "end_time > $now",
            );
        
         } 
    
    
    
    } else {
    
    $condition = array(
        
        'system' => 'Y',
        
         // "end_time > $now",
        );
    
    $selector = "current";
    
    } 

if (is_partner(true)) {
    
    $partner_id = abs(intval($_SESSION['partner_id']));
    
    $login_partner = Table::Fetch('partner', $partner_id);
    
    $condition = array($condition, 'partner_id' => $partner_id,);
    
    } 

$count = Table::Count('deals', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$deals = DB::LimitQuery('deals', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$cities = Table::Fetch('cities', Utility::GetColumn($deals, 'city_id'));

$groups = Table::Fetch('cities', Utility::GetColumn($deals, 'group_id'));

if (is_partner(true)) {
    
    include template('business_deals_index');
    
    } 

else {
    
    include template('manage_deals_index');
    
    } 
