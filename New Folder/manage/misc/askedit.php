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

$ask = Table::Fetch('ask', $id);

if (!$ask) {
    
    Utility::Redirect(BASE_REF . '/manage/misc/ask.php');
    
    } 

if ($_POST && $id == $_POST['id']) {
    
    $table = new Table('ask', $_POST);
    
     $table->SetStrip('comment', 'content');
    
     $table->update(array('comment', 'content'));
    
    
    
     // ACTIVITY LOG
    ZLog::Log($login_user_id, 'Comments', 'Comment updated, ID:' . $id);
    
     // ACTIVITY LOG
    
    
    Utility::Redirect(udecode($_GET['r']));
    
    } 

$deals = Table::Fetch('deals', $ask['deals_id']);

$user = Table::Fetch('user', $ask['user_id']);

include template('manage_misc_askedit');

