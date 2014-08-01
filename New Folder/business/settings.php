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

need_partner(true);

$partner_id = abs(intval($_SESSION['partner_id']));

$login_partner = $partner = Table::Fetch('partner', $partner_id);

if ($_POST) {
    
    $table = new Table('partner', $_POST);
    
     $table->SetStrip('location', 'other');
    
     $table->SetPk('id', $partner_id);
    
     $update = array(
        
        'title', 'bank_name', 'bank_user', 'bank_no',
        
         'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
        
         'address',
        
        );
    
     if ($table->password == $table->password2 && $table->password) {
        
        $update[] = 'password';
        
         $table->password = ZPartner::GenPassword($table->password);
        
         } 
    
    $flag = $table->update($update);
    
     if ($flag) {
        
        Session::Set('notice', TEXT_EN_CHANGE_PARTNER_INFORMATION_OK_EN);
        
         Utility::Redirect(BASE_REF . "/business/settings.php");
        
         } 
    
    Session::Set('error', TEXT_EN_CHANGE_PARTNER_INFORMATION_FAILED_EN);
    
     $partner = $_POST;
    
    } 

include template('business_settings');

