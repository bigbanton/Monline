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

($secret = strval($_GET['code'])) || ($secret = strval($_GET['email']));

if (empty($secret)) {
    
    ($email = Session::Get('unemail')) || ($email = $login_user['email']);
    
     $wwwlink = mail_zd($email);
    
     die(include template('user_verify'));
    
    } 

else if (strpos($secret, '@')) {
    
    Session::Set('unemail', $secret);
    
     mail_sign_email($secret);
    
     Utility::Redirect(BASE_REF . '/account/verify.php');
    
    } 

$user = Table::Fetch('user', $secret, 'secret');

if ($user) {
    
    Table::UpdateCache('user', $user['id'], array(
            
            'enable' => 'Y',
            
            ));
    
    
    
     // ACTIVITY LOG
    ZLog::Log($user['id'], 'Account Verified');
    
     // ACTIVITY LOG
    
    
    Session::Set('notice', TEXT_EN_CONGRATULATIONS_YOUR_REGISTRATION_IS_NOW_COMPLETE_EN);
    
     ZLogin::Login($user['id']);
    
     Utility::Redirect(get_loginpage(BASE_REF . '/index.php'));
    
    } 

Utility::Redirect(BASE_REF . '/index.php');

