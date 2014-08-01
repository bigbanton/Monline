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

if (isset($_SESSION['user_id'])) {
    
    unset($_SESSION['user_id']);
    
     ZLogin::NoRemember();
    
     $login_user = $login_user_id = $login_manager = $login_leader = null;
    
    } 

$code = strval($_GET['code']);

if ($code == 'ok' && is_get()) {
    
    die(include template('user_reset_ok'));
    
    } 

$user = Table::Fetch('user', $code, 'recode');

if (!$user) {
    
    Session::Set('error', 'Link for password resetting is invalid');
    
     Utility::Redirect(BASE_REF . '/index.php');
    
    } 

if (is_post()) {
    
    if ($_POST['password'] == $_POST['password2']) {
        
        $password = ZUser::GenPassword($_POST['password']);
        
         Table::UpdateCache('user', $user['id'], array(
                
                'password' => $password,
                
                 'recode' => '',
                
                ));
        
         Utility::Redirect(BASE_REF . '/account/reset.php?code=ok');
        
         } 
    
    Session::Set('error', 'The password you typed are diffrent, please type them again');
    
    } 

include template('user_reset');

