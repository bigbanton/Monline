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

need_login();

if ($_POST) {
    
    
    
    $_POST['create_time'] = time();
    
    
    
     $_POST['type'] = 0;
    
    
    
     $_POST['user_id'] = $login_user_id;
    
    
    
     $table = new Table('user_address', $_POST);
    
     $update = array(
        
        'address1', 'address2', 'city', 'state', 'country', 'pincode', 'phone', 'user_id', 'create_time', 'type',
        
        );
    
    
    
     if (abs(intval($_POST['id']))) {
        
        $table->SetPk('id', $_POST['id']);
        
         if ($table->update($update)) {
            
            Session::Set('notice', TEXT_EN_ACCOUNT_UPDATED_SUCCESSFULLY_EN);
            
             } else {
            
            echo "update failed";
            exit;
            
             Session::Set('error', TEXT_EN_ACCOUNT_SETTINGS_FAILED_EN);
            
             } 
        
        } else {
        
        if ($table->insert($update)) {
            
            Session::Set('notice', TEXT_EN_ACCOUNT_UPDATED_SUCCESSFULLY_EN);
            
             } else {
            
            echo "insert failed";
            exit;
            
             Session::Set('error', TEXT_EN_ACCOUNT_SETTINGS_FAILED_EN);
            
             } 
        
        
        
        } 
    
    
    
    Utility::Redirect(BASE_REF . '/account/settings.php ');
    
    } 

$user_address = DB::LimitQuery('user_address', array(
        
        'condition' => array('user_id' => $login_user_id),
        
         'size' => 1,
        
        ));

$user_address = $user_address[0];

include template('user_address');

