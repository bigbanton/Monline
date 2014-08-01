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
    
    
    
     unset($_SESSION['adbypass']);
    
    
    
     ZLogin::NoRemember();
    
    
    
     $fblogouturl = $_SESSION['FBCONNECT_LOGOUT_URL'];
    
     unset($_SESSION['FBCONNECT_LOGOUT_URL']);
    
    
    
    
    
     require_once(dirname(dirname(__FILE__)) . '/facebooklogout.php');
    
    
    
     if ($fblogouturl != '') {
        
        redirect($fblogouturl);
        
         redirect(BASE_REF . '/account/signup.php');
        
         } else {
        
        redirect(BASE_REF . '/account/signup.php');
        
         } 
    
    
    
    redirect(BASE_REF . '/account/signup.php');
    
    
    
    } 

if ($_POST) {
    
    
    
    if (isset($_GET['enroll']) && $_POST['step'] == 'next') {
        
        
        
        if (! Utility::ValidEmail($_POST['email'], true)) {
            
            
            
            Session::Set('error', TEXT_EN_THE_EMAIL_ID_IS_INVALID_EN);
            
            
            
             Utility::Redirect(BASE_REF . '/account/signup.php?enroll');
            
            
            
             } 
        
        
        
        $au = Table::Fetch('user', $_POST['email'], 'email');
        
        
        
         if ($au) {
            
            
            
            Session::Set('error', TEXT_EN_THE_EMAIL_ID_IS_ALREADY_REGISTERED_EN);
            
            
            
             Utility::Redirect(BASE_REF . '/account/signup.php?enroll');
            
             } 
        
        
        
        
        
        $city_id = abs(intval($_POST['city_id']));
        
        
        
         ZSubscribe::Create($_POST['email'], $city_id);
        
        
        
         cookie_city($city = Table::Fetch('cities', $city_id));
        
        
        
         cookieset("subs", "1");
        
        
        
         die(include template('user_signup_2'));
        
        
        
         } 
    
    
    
    
    
    
    
    $u = array();
    
    
    
     // $u['username'] = strval($_POST['username']);
    
    
    $u['password'] = strval($_POST['password']);
    
    
    
     $u['email'] = strval($_POST['email']);
    
    
    
     $u['city_id'] = abs(intval($_POST['city_id']));
    
    
    
     $u['mobile'] = strval($_POST['mobile']);
    
    
    
     $u['realname'] = $_POST['realname'];
    
    
    
    
    
    
    
     if ($_POST['password2'] == $_POST['password'] && $_POST['password']) {
        
        
        
        if ($INI['system']['emailverify']) {
            
            
            
            $u['enable'] = 'N';
            
            
            
             } 
        
        
        
        if ($user_id = ZUser::Create($u)) {
            
            
            
            if ($INI['system']['emailverify']) {
                
                
                
                mail_sign_id($user_id);
                
                
                
                 Session::Set('unemail', $_POST['email']);
                
                
                
                 Utility::Redirect(BASE_REF . '/account/verify.php');
                
                
                
                 } else {
                
                
                
                ZLogin::Login($user_id);
                
                
                
                 // Utility::Redirect(get_loginpage(BASE_REF . '/index.php'));
                
                
                Utility::Redirect(BASE_REF . '/index.php');
                
                
                
                 } 
            
            
            
            } else {
            
            
            
            $au = Table::Fetch('user', $_POST['email'], 'email');
            
            
            
             if ($au) {
                
                
                
                Session::Set('error', TEXT_EN_THE_EMAIL_ID_IS_ALREADY_REGISTERED_EN);
                
                
                
                 } else {
                
                
                
                Session::Set('error', TEXT_EN_THE_USERNAME_IS_NOT_AVAILABLE_EN);
                
                
                
                 } 
            
            
            
            } 
        
        
        
        } else {
        
        
        
        Session::Set('error', TEXT_EN_PASSWORD_ERROR_OR_MISMATCH_EN);
        
        
        
         } 
    
    
    
    } 

include template('user_signup');

