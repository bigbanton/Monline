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
$condition = array();

/**
 * filter
 */

$ptitle = strval($_GET['ptitle']);

if ($ptitle) {
    
    $condition[] = "title LIKE '%" . mysql_escape_string($ptitle) . "%'";
    
    } 

/**
 * filter end
 */

$count = Table::Count('partner', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$partners = DB::LimitQuery('partner', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

include template('manage_partner_index');

