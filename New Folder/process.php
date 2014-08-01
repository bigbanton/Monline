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

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();

$id = abs(intval($_GET['r']));

if ($id) {
    
    if ($login_user_id) {
        
        ZInvite::CreateFromId($id, $login_user_id);
        
         } else {
        
        $longtime = 86400 * 3; //3 days
        
        
         cookieset('_rid', $id, $longtime);
        
         } 
    
    } 

Utility::Redirect(BASE_REF . '/index.php');

