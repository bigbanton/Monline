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

$ename = strval($_GET['ename']);

($currefer = strval($_GET['refer'])) || ($currefer = strval($_GET['r']));

if ($ename != 'none' || $ename != 'showall') {
    
    $city = Table::Fetch('cities', $ename, 'ename');
    
     if ($city) {
        
        cookie_city($city);
        
         $currefer = udecode($currefer);
        
         if ($currefer) {
            
            Utility::Redirect($currefer);
            
             } else if ($_SERVER['HTTP_REFERER']) {
            
            if (!preg_match('#' . $_SERVER['HTTP_HOST'] . '#', $_SERVER['HTTP_REFERER'])) {
                
                Utility::Redirect(BASE_REF . '/index.php');
                
                 } 
            
            if (preg_match('#/city#', $_SERVER['HTTP_REFERER'])) {
                
                Utility::Redirect(BASE_REF . '/index.php');
                
                 } 
            
            Utility::Redirect($_SERVER['HTTP_REFERER']);
            
             } 
        
        Utility::Redirect(BASE_REF . '/index.php');
        
         } 
    
    } 

$cities = DB::LimitQuery('cities', array(
        
        'condition' => array('zone' => 'city') ,
        
        ));
        

$cities = Utility::AssColumn($cities, 'letter', 'ename');

include template('city');

