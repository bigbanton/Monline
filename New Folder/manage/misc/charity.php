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
$module = 'home';
$system = Table::Fetch('system', 1);

if ($_POST) {
    
    unset($_POST['commit']);
    
     $INI = Config::MergeINI($INI, $_POST);
    
     $INI = ZSystem::GetUnsetINI($INI);
    
    
    
     $value = Utility::ExtraEncode($INI);
    
     $table = new Table('system', array('value' => $value));
    
     if ($system) $table->SetPK('id', 1);
    
     $flag = $table->update(array('value'));
    
    
    
     Session::Set('notice', TEXT_EN_INFORMATION_HAS_BEEN_UPDATED_EN);
    
     Utility::Redirect(BASE_REF . '/manage/misc/charity.php');
    
    } 

$condition = array(
    
    'select' => 'SUM(value)',
    
    );

$query = DB::LimitQuery('charity', array(
        
        'select' => 'SUM(value)',
        
        ));

$contents = $query[0]['sum(value)'];

include template('manage_misc_charity');

