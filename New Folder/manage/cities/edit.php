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
$module = 'cities';
$id = abs(intval($_REQUEST['id']));

$category = Table::Fetch('cities', $id);

$table = new Table('cities', $_POST);

$_POST['zone'] = (isset($_POST['zone']))?$_POST['zone']:'city';

$table->letter = strtoupper($table->letter);

$uarray = array('zone', 'ename', 'letter', 'name', 'czone');

if (!$_POST['name'] || !$_POST['ename'] || !$_POST['letter']) {
    
    Session::Set('error', TEXT_EN_CAN_NOT_LEAVE_BLANK_FOR_FULL_NAME_SHORT_NAME_AND_FIRST_LETTER_EN);
    
     Utility::Redirect(null);
    
    } 

if ($category) {
    
    if ($flag = $table->update($uarray)) {
        
        // ACTIVITY LOG
        global $login_user_id;
        
         ZLog::Log($login_user_id, 'City Updated', 'City:' . $uarray['name']);
        
         // ACTIVITY LOG
        
        
        Session::Set('notice', TEXT_EN_EDIT_CATEGORY_DONE_EN);
        
         } else {
        
        Session::Set('error', TEXT_EN_EDIT_CATEGORY_FAILED_EN);
        
         } 
    
    option_category($category['zone'], true);
    
    } else {
    
    if ($flag = $table->insert($uarray)) {
        
        // ACTIVITY LOG
        global $login_user_id;
        
         ZLog::Log($login_user_id, 'City Added', 'City:' . $uarray['name']);
        
         // ACTIVITY LOG
        
        
        Session::Set('notice', TEXT_EN_CREATE_NEW_CATEGORY_DONE_EN);
        
         } else {
        
        Session::Set('error', TEXT_EN_CREATE_NEW_CAGEGORY_FAILED_EN);
        
         } 
    
    } 

option_category($table->zone, true);

Utility::Redirect(null);

