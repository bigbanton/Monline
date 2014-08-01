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

if (isset($_SESSION['agent_id'])) {
    
    // ACTIVITY LOG
    ZLog::Log($_SESSION['agent_id'], 'Agent Logout', 'Agent ID:' . $_SESSION['agent_id']);
    
     // ACTIVITY LOG
    } elseif (isset($_SESSION['partner_id'])) {
    
    // ACTIVITY LOG
    ZLog::Log($_SESSION['partner_id'], 'Partner Logout', 'Partner ID:' . $_SESSION['partner_id']);
    
     // ACTIVITY LOG
    } 

if (isset($_SESSION['partner_id'])) unset($_SESSION['partner_id']);

if (isset($_SESSION['agent_id'])) unset($_SESSION['agent_id']);

Utility::Redirect(BASE_REF . '/business/login.php');

