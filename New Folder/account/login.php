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

if ($_POST) {
    
    
    
    if (! Utility::ValidEmail($_POST['email'], true)) {
        
        Session::Set('error', TEXT_EN_THE_EMAIL_ID_IS_INVALID_EN);
        
         Utility::Redirect(BASE_REF . '/account/login.php');
        
         } 
    
    
    
    $login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
    
    
    
     if (!$login_user) {
        
        
        
        // ACTIVITY LOG
        ZLog::Log($login_user_id, 'Login', $_POST['email'], 1);
        
         // ACTIVITY LOG
        
        
        Session::Set('error', 'Login Failed. Invalid username or password.');
        
        
        
         Utility::Redirect(BASE_REF . '/account/login.php');
        
        
        
         } else if ($INI['system']['emailverify']
        
        
        
         && $login_user['enable'] == 'N'
        
        
        
         && $login_user['secret']
        
        
        
        ) {
        
        
        
        Session::Set('unemail', $_POST['email']);
        
        
        
         Utility::Redirect(BASE_REF . '/account/verify.php');
        
        
        
         } else {
        
        
        
        Session::Set('user_id', $login_user['id']);
        
        
        
         if ($_POST['auto-login'] == 1) {
            
            ZLogin::Remember($login_user);
            
             } else {
            
            ZLogin::NoRemember();
            
             } 
        
        
        
        $now = time();
        
        
        
         $user = Table::Fetch('user', $login_user_id, 'id');
        
        
        
         $_SESSION['last_login'] = $user['login_time'];
        
        
        
         Table::UpdateCache('user', $login_user_id, array('login_time' => $now,));
        
        
        
         // ACTIVITY LOG
        ZLog::Log($login_user['id'], 'Login', $_POST['email']);
        
         // ACTIVITY LOG
        
        
        if (is_manager()) Utility::Redirect(BASE_REF . '/manage/misc/index.php');
        
        
        
         $loginref = Session::Get('loginref', true);
        
        
        
         $returnURL = ($loginref) ? urlDecode($loginref) : BASE_REF . '/index.php';
        
        
         if (strpos($returnURL, 'code=ok')) {
            $returnURL = BASE_REF . '/index.php';
             } 
        
        Utility::Redirect($returnURL);
        
        
        
         } 
    
    
    
    } 

$ref = getenv("HTTP_REFERER");

if (strpos(strtolower(getenv("HTTP_REFERER")), strtolower($_SERVER["SERVER_NAME"]))) {
    Session::Set('loginref', $ref);
} 

include template('user_login');

