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

if (is_post()) {
    
    $user = Table::Fetch('user', strval($_POST['email']), 'email');
    
     if ($user) {
        
        $user['recode'] = $user['recode'] ? $user['recode'] : md5(json_encode($user));
        
         Table::UpdateCache('user', $user['id'], array(
                
                'recode' => $user['recode'],
                
                ));
        
         mail_repass($user);
        
         Session::Set('reemail', $user['email']);
        
         Utility::Redirect(BASE_REF . '/account/repass.php?action=ok');
        
         } 
    
    Session::Set('error', 'This is an invalid email id.');
    
     Utility::Redirect(BASE_REF . '/account/repass.php');
    
    } 

$action = strval($_GET['action']);

if ($action == 'ok') {
    
    die(include template('user_repass_ok'));
    
    } 

include template('user_repass');

