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
$module = 'marketing';
if ($_POST) {
    
    $_POST['content'] = stripslashes($_POST['content']);
    
    
    
     $content = $_POST['content'];
    
     $emails = $_POST['emails'];
    
     $subject = $_POST['title'];
    
    
    
     $emails = preg_split('/[\s,]+/', $emails, -1, PREG_SPLIT_NO_EMPTY);
    
     $emails_array = array();
    
     foreach($emails AS $one) if (Utility::ValidEmail($one)) $emails_array[] = $one;
    
     $email_count = count($emails_array);
    
    
    
     $hostprefix = "http://{$_SERVER['HTTP_HOST']}/";
    
     $content = str_ireplace('href="/', "href=\"{$hostprefix}", $content);
    
    
    
     if (!$email_count) {
        
        Session::Set('error', TEXT_EN_ERROR_IN_SENDING_EMAIL_NO_LEGAL_RECIPIENTS_EN);
        
         } else {
        
        try {
            
            mail_custom($emails_array, $subject, $content);
            
            
            
             // ACTIVITY LOG
            ZLog::Log($login_user_id, 'Email Sent', 'Mass email sent to ' . $email_count . ' users');
            
             // ACTIVITY LOG
            
            
            Session::Set('notice', "Send Email OK. Amount: {$email_count}");
            
             Utility::Redirect(BASE_REF . '/manage/market/index.php');
            
             } 
        catch(Exception $e) {
            
            
            
            // ACTIVITY LOG
            ZLog::Log($login_user_id, 'Email Error', 'Alert >> Mass email not sent to ' . $email_count . ' users', 1);
            
             // ACTIVITY LOG
            
            
            Session::Set('error', TEXT_EN_ERROR_IN_SENDING_EMAIL_EN);
            
             } 
        
        } 
    
    } 

include template('manage_market_email');

