<?php

/**
 * //File information must not be removed
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

$id = abs(intval($_REQUEST['id']));

$now = time();

if ($id) {
    
    $oc = array(
        
        'id' => $id,
        
         "begin_time < {$now}",
        
         "end_time > {$now}",
        
         'stage' => array('1-featured', 'approved'),
        
        );
    
    } else {
    
    $oc = array(
        
        "begin_time < {$now}",
        
         "end_time > {$now}",
        
         'stage' => array('1-featured', 'approved'),
        
        );
    
    } 

$deals = DB::LimitQuery('deals', array(
        
        'condition' => $oc,
        
         'size' => 1,
        
         'order' => 'ORDER BY stage',
        
        ));

$deals = $deals[0];

include template('deal_widget');

