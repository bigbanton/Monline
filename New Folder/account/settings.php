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

$quer = strval($_GET['q']);

$imgpath = strval($_GET['p']);

$login_av = strval($_GET['r']);

if ($quer == 'remav') {
    
    if (remove_image($imgpath, $login_av)) {
        
        Session::Set('notice', TEXT_EN_PROFILE_IMAGE_IS_DELETED_EN);
        
        } 
    
    else {
        
        Session::Set('error', TEXT_EN_ERROR_DELETING_PROFILE_IMAGE_EN);
        
        } 
    
    Utility::Redirect(BASE_REF . '/account/settings.php ');
    
    } 

if ($_POST) {
    
    $table = new Table('user', $_POST);
    
     $table->SetPk('id', $login_user_id);
    
     $update = array(
        
        'username', 'realname', 'zipcode',
        
         'address', 'mobile', 'avatar', 'gender', 'city_id', 'email',
        
        );
    
     if ($table->password == $table->password2 && $table->password) {
        
        $update[] = 'password';
        
         $table->password = ZUser::GenPassword($table->password);
        
         } 
    
    // $table->avatar=upload_image('upload_image',$login_user['avatar'],'user');
    $table->avatar = upload_image_user('upload_image', $login_user['avatar'], 'user', $login_user_id);
    
     if ($table->update($update)) {
        
        Session::Set('notice', TEXT_EN_ACCOUNT_UPDATED_SUCCESSFULLY_EN);
        
         Utility::Redirect(BASE_REF . '/account/settings.php ');
        
         } else {
        
        Session::Set('error', TEXT_EN_ACCOUNT_SETTINGS_FAILED_EN);
        
         } 
    
    } 

$user_address = DB::LimitQuery('user_address', array(
        
        'condition' => array('user_id' => $login_user_id),
        
         'size' => 1,
        
        ));

include template('user_settings');

