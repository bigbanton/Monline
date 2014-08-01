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
    
    $gender = $_POST['gender'];
    
     $newbie = $_POST['newbie'];
    
     $city_id = $_POST['city_id'];
    
     if (!$city_id || !$newbie || !$gender) die('-ERR ERR_CHECK');
    
    
    
     $condition = array(
        
        'gender' => $gender,
        
         'newbie' => $newbie,
        
         'city_id' => $city_id,
        
        );
    
    
    
     $users = DB::LimitQuery('user', array(
            
            'condition' => $condition,
            
             'user' => 'ORDER BY id DESC',
            
            ));
    
    
    
     if (!$users) die('-ERR ERR_NO_DATA');
    
    
    
     $name = 'user_' . date('Ymd');
    
     $kn = array(
        
        'email' => 'Email',
        
         'id' => 'ID',
        
         'username' => 'Username',
        
         'realname' => 'Realname',
        
         'gender' => 'Sex',
        
         'qq' => 'QQ',
        
         'mobile' => 'Handphone',
        
         'zipcode' => 'Postcode',
        
         'address' => 'Address',
        
         'newbie' => 'Buy',
        
        );
    
    
    
     $gender = array(
        
        'M' => 'Male',
        
         'F' => 'Female',
        
        );
    
     $newbie = array(
        
        'Y' => 'Yes',
        
         'N' => 'No',
        
        );
    
    
    
     $eusers = array();
    
     foreach($users AS $one) {
        
        $one['gender'] = $gender[$one['gender']];
        
         $one['newbie'] = $newbie[$one['newbie']];
        
         $eusers[] = $one;
        
         } 
    
    down_xls($eusers, $kn, $name);
    
    } 

include template('manage_market_downuser');

