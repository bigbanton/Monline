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

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();

$daytime = time();

 if (isset($_GET['cat']) && strtolower($_GET['cat']) !== 'all') {
    
    $condition = array(
        
        "(city_id = '0' OR find_in_set({$city['id']},city_id))",
        
         "begin_time >  {$daytime}",
        
         'stage' => array('1-featured', 'approved'),
        
         'product' => $_GET['cat'],
        
        );
    
     } else {
    
    $condition = array(
        
        "(city_id = '0' OR find_in_set({$city['id']},city_id))",
        
         "begin_time >  {$daytime}",
        
         'stage' => array('1-featured', 'approved'),
        
        );
    
    
    
     } 

$count = Table::Count('deals', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$now = time();

$deals = DB::LimitQuery('deals', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY stage ASC, end_time ASC, begin_time ASC, id ASC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        
        
        ));

$livecounter = 0;

$missedcounter = 0;

foreach($deals AS $id => $one) {
    
    $deals[$id]['states'] = deals_state($one);
    
     if ($one['end_time'] > $now && $deals[$id]['states'] != 'soldout' && ($one['stage'] == 'approved' || $one['stage'] == '1-featured')) {
        
        $one['picclass'] = 'isopen';
        
         $livecounter += 1;
        
         } else if ($deals[$id]['states'] == 'soldout' || $one['end_time'] < $now && ($one['stage'] == 'approved' || $one['stage'] == '1-featured')) {
        
        $one['picclass'] = 'soldout';
        
         $missedcounter += 1;
        
         } 
    
    $deals[$id] = $one;
    
    } 

$pagetitle = 'Upcoming Deals';

include template('deals_upcoming');

