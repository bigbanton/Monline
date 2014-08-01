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
$like = strval($_GET['like']);

$cs = strval($_GET['cs']);

/**
 * build condition
 */

$condition = array();

if ($like) {
    
    $condition[] = "email like '%" . mysql_escape_string($like) . "%'";
    
    } 

if ($cs) {
    
    $cscity = DB::LimitQuery('cities', array(
            
            'condition' => array(
                
                'zone' => 'city',
                
                 'name' => $cs,
                
                ),
            
             'one' => true,
            
            ));
    
     if ($cscity) $condition['city_id'] = $cscity['id'];
    
     else $cs = null;
    
    } 

/**
 * end
 */

$count = Table::Count('subscribe', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 50);

$subscribes = DB::LimitQuery('subscribe', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$city_ids = Utility::GetColumn($subscribes, 'city_id');

$cities = Table::Fetch('cities', $city_ids);

include template('manage_misc_subscribe');

