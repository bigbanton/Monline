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
$action = strval($_GET['action']);

$id = abs(intval($_GET['id']));

$r = udecode($_GET['r']);

$cate = strval($_GET['cate']);

$like = strval($_GET['like']);

if ($action == 'r') {
    
    Table::Delete('feedback', $id);
    
     Utility::Redirect($r);
    
    } else if ($action == 'm') {
    
    Table::UpdateCache('feedback', $id, array('user_id' => $login_user_id));
    
     Utility::Redirect($r);
    
    } 

$condition = array();

if ($cate) {
    $condition['category'] = $cate;
} 

if ($like) {
    
    $condition[] = "content like '%" . mysql_escape_string($like) . "%'";
    
    } 

$count = Table::Count('feedback', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$asks = DB::LimitQuery('feedback', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$user_ids = Utility::GetColumn($asks, 'user_id');

$users = Table::Fetch('user', $user_ids);

$feedcate = array('suggest' => 'Feedback', 'seller' => 'Business suggestion');

include template('manage_misc_feedback');

