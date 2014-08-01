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
    
    if (!$_POST['content'] || !$_POST['title'] || !$_POST['contact']) {
        
        Session::Set('error', TEXT_EN_PLEASE_DO_NOT_SUBMIT_IT_UNTILL_FINISHED_EN);
        
         Utility::Redirect(BASE_REF . '/feedback/seller.php');
        
         } 
    
    $table = new Table('feedback', $_POST);
    
     $table->city_id = $city['id'];
    
     $table->create_time = time();
    
     $table->category = 'suggest';
    
     $table->Insert(array(
            
            'city_id', 'title', 'contact', 'content', 'create_time',
            
             'category',
            
            ));
    
     Utility::Redirect(BASE_REF . '/feedback/success.php');
    
    } 

include template("feedback_suggest");

