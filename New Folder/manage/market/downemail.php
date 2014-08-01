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

if ($_POST) {
    
    $city_id = $_POST['city_id'];
    
     $source = $_POST['source'];
    
     if (empty($city_id)) die('-ERR ERR_NO_DATA');
    
     if (empty($source)) die('-ERR ERR_NO_DATA');
    
    
    
     $emails = array();
    
    
    
     if (in_array('user', $source)) {
        
        $rows = DB::LimitQuery('user', array(
                
                'condition' => array(
                    
                    'city_id' => $city_id,
                    
                    ),
                
                 'select' => 'email',
                
                ));
        
         foreach($rows As $one) {
            
            $emails[] = array('email' => $one['email']);
            
             } 
        
        } 
    
    if (in_array('subscribe', $source)) {
        
        $rows = DB::LimitQuery('subscribe', array(
                
                'condition' => array(
                    
                    'city_id' => $city_id,
                    
                    ),
                
                 'select' => 'email',
                
                ));
        
         foreach($rows As $one) {
            
            $emails[] = array('email' => $one['email']);
            
             } 
        
        } 
    
    
    
    if ($emails) {
        
        $kn = array(
            
            'email' => 'Email',
            
            );
        
         $name = "email_" . date('Ymd');
        
         down_xls($emails, $kn, $name);
        
         } 
    
    die('-ERR ERR_NO_DATA');
    
    } 

include template('manage_market_downemail');

