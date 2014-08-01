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
$module = 'home';
$title = strval($_GET['title']);

$condition = array(
    
    'deals_id > 0',
    
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

$count = Table::Count('ask', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$asks = DB::LimitQuery('ask', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$user_ids = Utility::GetColumn($asks, 'user_id');

$deals_ids = Utility::GetColumn($asks, 'deals_id');

$users = Table::Fetch('user', $user_ids);

$deals = Table::Fetch('deals', $deals_ids);

include template('manage_misc_ask');

