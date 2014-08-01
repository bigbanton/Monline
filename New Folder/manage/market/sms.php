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

if ($_POST) {
    
    $phones = preg_split('/[\s,]+/', $_POST['phones'], -1, PREG_SPLIT_NO_EMPTY);
    
     $content = trim(strval($_POST['content']));
    
     $phone_count = count($phones);
    
     $phones = implode(',', $phones);
    
     $ret = sms_send($phones, $content);
    
     if ($ret === true) {
        
        
        
        // ACTIVITY LOG
        ZLog::Log(0, 'SMS Sent');
        
         // ACTIVITY LOG
        
        
        Session::Set('notice', "Sending SMS: {$phone_count}");
        
         Utility::Redirect(BASE_REF + '/manage/market/sms.php');
        
         } 
    
    
    
    // ACTIVITY LOG
    ZLog::Log($login_user_id, 'SMS Error', 'Alert >> SMS send error', 1);
    
     // ACTIVITY LOG
    
    
    Session::Set('notice', "Error occured while sending SMS, error code: {$ret}");
    
    } 

include template('manage_market_sms');

