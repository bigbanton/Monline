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

require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();

$source = strval($_GET['source']);

$daytime = strtotime(date('Y-m-d'));

$condition = array('begin_time' => $daytime,);

$deals = DB::LimitQuery('deals', array(
        
        'condition' => $condition,
        
        ));

$oa = array();

$si = array(
    
    'sitename' => $INI['system']['sitename'],
    
     'wwwprefix' => $INI['system']['wwwprefix'],
    
     'imgprefix' => $INI['system']['imgprefix'],
    
    );

foreach($deals AS $one) {
    
    $city = Table::Fetch('cities', $one['city_id']);
    
     $group = Table::Fetch('cities', $one['group_id']);
    
     $o = array();
    
     $o['id'] = $one['id'];
    
     $o['image'] = $one['image'];
    
     $o['image1'] = $one['image1'];
    
     $o['image2'] = $one['image2'];
    
     $o['title'] = $one['title'];
    
     $o['product'] = $one['product'];
    
     $o['deals_price'] = $one['deals_price'];
    
     $o['market_price'] = $one['market_price'];
    
     $o['city'] = $city['name'];
    
     $o['group'] = $group['name'];
    
     $oa[$one['id']] = $o;
    
    } 

$o = array('site' => $si, 'deals' => $oa);

Output::Json($o);

