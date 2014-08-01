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

$deals = Table::Fetch('deals', $id);

$order = Table::Fetch('order', $id, 'deals_id');

if ($order) {
    
    Session::Set('notice', "Delete ({$id}) record failed, record has order.");
    
    } else {
    
    
    
    // ACTIVITY LOG
    global $login_user_id;
    
     ZLog::Log($login_user_id, 'Deal Deleted', 'Alert >> Deal deleted, Type:Regular, ID:' . $id);
    
     // ACTIVITY LOG
    
    
    Table::Delete('deals', $id);
    
     Session::Set('notice', "Delete ({$id}) record is done.");
    
    } 

Utility::Redirect(udecode($_GET['r']));

