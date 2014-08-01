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

need_manager(true);

$version = strval(SYS_VERSION);

$action = strval($_GET['action']);

if ('db' == $action) {
    
    $r = TGS_upgrade($action, $version);
    
     Session::Set('notice', TEXT_EN_DATABASE_IS_UPDATED_EN);
    
     Utility::Redirect(BASE_REF . '/manage/system/upgrade.php');
    
    } 

/**
 * $version_meta = TGS_version();
 * 
 * $newversion = $version_meta['version'];
 * 
 * $software = $version_meta['software'];
 * 
 * 
 * 
 * $install = $version_meta['install'];
 * 
 * $patch = $version_meta['patch'];
 * 
 * $patchdesc = $version_meta['patchdesc'];
 * 
 * $upgrade = $version_meta['upgrade'];
 * 
 * $upgradedesc = $version_meta['upgradedesc'];
 * 
 * 
 * 
 * $isnew = ( $newversion == $version );
 */

include template('manage_system_upgrade');

