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

if ($_POST) {
    
    $login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
    
     if (!$login_user) {
        
        Session::Set('error', TEXT_EN_FAILED_IN_LOGIN_EN);
        
         Utility::Redirect(BASE_REF . '/account/login.php');
        
         } else if ($INI['system']['emailverify']
        
         && $login_user['enable'] == 'N'
        
         && $login_user['secret']
        
        ) {
        
        Session::Set('unemail', $_POST['email']);
        
         Utility::Redirect(BASE_REF . '/account/verify.php');
        
         } else {
        
        Session::Set('user_id', $login_user['id']);
        
         ZLogin::Remember($login_user);
        
         Utility::Redirect(get_loginpage(BASE_REF . '/index.php'));
        
         } 
    
    } 

$currefer = strval($_GET['r']);

if ($currefer) {
    Session::Set('loginpage', udecode($currefer));
} 

include template('account_login');

