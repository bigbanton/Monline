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
$module = 'users';
$like = strval($_GET['like']);

$uname = strval($_GET['uname']);

$ucity = abs(intval($_GET['ucity']));

$cs = strval($_GET['cs']);

$condition = array();

/**
 * filter
 */

if ($like) {
    
    $condition[] = "email like '%" . mysql_escape_string($like) . "%'";
    
    } 

if ($uname) {
    
    $condition[] = "username like '%" . mysql_escape_string($uname) . "%'";
    
    } 

if (abs(intval($ucity))) {
    
    $condition['city_id'] = abs(intval($ucity));
    
    } 

/**
 * end
 */

$count = Table::Count('user', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$users = DB::LimitQuery('user', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

include template('manage_user_index');

