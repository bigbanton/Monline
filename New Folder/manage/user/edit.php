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

$id = abs(intval($_GET['id']));

$user = Table::Fetch('user', $id);

if ($_POST && $id == $_POST['id']) {
    
    $table = new Table('user', $_POST);
    
     $up_array = array(
        
        'username', 'realname',
        
         'mobile', 'zipcode', 'address',
        
         'secret',
        
        );
    
     if ($login_user_id == 1 && $id > 1) {
        $up_array[] = 'manager';
    } 
    
    if ($id == 1 && $login_user_id > 1) {
        
        Session::Set('notice', TEXT_EN_YOU_ARE_NOT_ALLOW_TO_MODIFY_ADMIN_INFORMATION_EN);
        
         Utility::Redirect(BASE_REF . "/manage/user/index.php");
        
         } 
    
    $table->manager = (strtoupper($table->manager) == 'Y') ? 'Y' : 'N';
    
     if ($table->password) {
        
        $table->password = ZUser::GenPassword($table->password);
        
         $up_array[] = 'password';
        
         } 
    
    $flag = $table->update($up_array);
    
     if ($flag) {
        
        Session::Set('notice', TEXT_EN_USER_INFORMATION_IS_UPDATED_EN);
        
         Utility::Redirect(BASE_REF . "/manage/user/edit.php?id={$id}");
        
         } 
    
    Session::Set('error', TEXT_EN_FAILED_IN_UPDATE_USER_INFORMATION_EN);
    
     $user = $_POST;
    
    } 

include template('manage_user_edit');

