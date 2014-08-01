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
    
    $login_partner = ZPartner::GetLogin($_POST['username'], $_POST['password']);
    
     if (!$login_partner) {
        
        
        
        $login_agent = ZPartner::AgentLogin($_POST['username'], $_POST['password']);
        
        
        
         if (!$login_agent) {
            
            
            
            
            
            
            
            // Added on 11-12-2011 By Sachin Bhatia
            // If not business user, check site admin credentials and redirect to admin panel
            
            
            $login_user = ZUser::GetLogin($_POST['username'], $_POST['password']);
            
            
            
             if ($login_user && is_manager()) {
                
                
                
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
                
                
                Utility::Redirect(BASE_REF . '/manage/misc/index.php');
                
                
                
                 die('Invalid access page. Please go back.');
                
                 } 
            
            
            
            
            
            // ACTIVITY LOG
            ZLog::Log(0, 'Agent Login', 'Alert >> Agent/Partner login failed. Username used:' . $_POST['username'], 1);
            
             // ACTIVITY LOG
            
            
            Session::Set('error', TEXT_EN_USERNAME_AND_PASSWORD_ARE_NOT_MATCHED_EN);
            
             Utility::Redirect(BASE_REF . '/business/login.php');
            
            
            
             } else {
            
            
            
            // ACTIVITY LOG
            ZLog::Log(0, 'Agent Login', 'Agent ID:' . $login_agent['id']);
            
             // ACTIVITY LOG
            
            
            Session::Set('agent_id', $login_agent['id']);
            
             Utility::Redirect(BASE_REF . '/business/index.php');
            
            
            
             } 
        
        
        
        } else {
        
        
        
        // ACTIVITY LOG
        ZLog::Log(0, 'Partner Login', 'Partner ID:' . $login_partner['id']);
        
         // ACTIVITY LOG
        
        
        Session::Set('partner_id', $login_partner['id']);
        
         Utility::Redirect(BASE_REF . '/business/index.php');
        
        
        
         } 
    
    } 

include template('business_login');

