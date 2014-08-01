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
if (!empty($_POST)) {
    
    $strError = 0;
    
     if (!empty($_POST['commission']) && !is_numeric($_POST['commission']) || $_POST['commission'] < 0 || $_POST['commission'] > 100) { // to validate the commission value
        
        $strError = 1;
        
         Session::Set('error', 'Please enter the valid commission value');
        
         } 
    
    if ($strError == 0) { // if commission value is validated, goes to insert
        
        $table = new Table('partner', $_POST);
        
         $table->SetStrip('location', 'other');
        
         $table->create_time = time();
        
         $table->user_id = $login_user_id;
        
         $table->password = ZPartner::GenPassword($table->password);
        
         $table->insert(array(
                
                'username', 'user_id', 'city_id', 'title',
                
                 'bank_name', 'bank_user', 'bank_no', 'create_time',
                
                 'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
                
                 'password', 'address', 'commission'
                
                ));
        
        
        
         // ACTIVITY LOG
        ZLog::Log($login_user_id, 'Partner Added', 'New partner created:' . $_POST['username']);
        
         // ACTIVITY LOG
        
        
        Utility::Redirect(BASE_REF . '/manage/partner/index.php');
        
         } 
    
    } 

include template('manage_partner_create');

