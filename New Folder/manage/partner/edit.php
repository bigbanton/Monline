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

$partner = Table::Fetch('partner', $id);

if ($_POST && $id == $_POST['id']) {
    
    $table = new Table('partner', $_POST);
    
     $table->SetStrip('location', 'other');
    
     $up_array = array(
        
        'username', 'title', 'bank_name', 'bank_user', 'bank_no',
        
         'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
        
        
        
         'address', 'commission'
        
        
        
        );
    
    
    
     if ($table->password) {
        
        $table->password = ZPartner::GenPassword($table->password);
        
         $up_array[] = 'password';
        
         } 
    
    $flag = $table->update($up_array);
    
     if ($flag) {
        
        
        
        // ACTIVITY LOG
        ZLog::Log($login_user_id, 'Partner Updated', 'Partner information updated, ID:' . $_POST['id']);
        
         // ACTIVITY LOG
        
        
        Session::Set('notice', TEXT_EN_CHANGE_PARTNER_INFORMATION_DONE_EN);
        
         Utility::Redirect(BASE_REF . "/manage/partner/edit.php?id={$id}");
        
         } 
    
    
    
    // ACTIVITY LOG
    ZLog::Log($login_user_id, 'Partner Edit Failed', 'Alert >> Partner updated failed, ID:' . $_POST['id']);
    
     // ACTIVITY LOG
    
    
    Session::Set('error', TEXT_EN_CHANGE_PARTNER_INFORMATION_FAILED_EN);
    
     $partner = $_POST;
    
    } 

include template('manage_partner_edit');

