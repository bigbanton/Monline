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

if (!file_exists(dirname(__FILE__) . '/app.php') || !file_exists(dirname(__FILE__) . '/config.php')) die('Config.php Entry Error. File system missing or this is not a root installation. Exiting system.');

require_once(dirname(__FILE__) . '/config.php');

if (!file_exists(DIR_BACKEND . '/configure/system.php')) die('<b>Configuration Error:</b> You must edit the <b>config.php</b> file and correctly specify the variables.<br/><br/>Follow the installation instructions in the <a href="https://secure.gripsell.com/support/manual/Grpprosec/index.php" target="_blank">help manual.</a>');

include(DIR_BACKEND . '/configure/system.php');

if (!$INI['db']['name']) header("Location: ./install.php");

if ($_SERVER["SERVER_NAME"] != 'example.com' && !strpos($_SERVER["SERVER_NAME"], 'example.com') && (file_exists('install.php') || file_exists('ossetup.php'))) {
    
    echo 'Installation complete. For security reason, you must now delete \'install.php\' and \'ossetup.php\'.';
    
     if (isset($_GET['sampledata'])) {
        
        echo '<br/><br/><p style="font-family:Arial; color:#006699;font-size:14px;">Your super admin login details are as follow:<ul><li><b>Username:</b> info@cloneportal.com</li><li><b>Password:</b> demopro<br/><br/></li><li>You can change username and password later.</li></ul></p>';
        
         } 
    
    exit();
    
    } 

ob_start();

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();

/**
 * set the countdown
 */

$now = time();

if (($INI['prerel']['releaser'] || $_GET['preview'] == 'releaser') && $_GET['preview'] !== $INI['prerel']['releasecode'] && mktime($INI['prerel']['releasehour'], $INI['prerel']['releasemin'], $INI['prerel']['releasesec'], $INI['prerel']['releasemonth'], $INI['prerel']['releasedate'], $INI['prerel']['releaseyear']) > $time) {
    
    include 'countdown.php';
    
     exit();
    
    } 

if (abs(intval($INI['system']['mobile'])) && abs(intval($INI['system']['mservice']))) {
    
    // code for mobile device detection and redirect to mobile version
    define('MOBILE_VERSION_URL', $INI['system']['mlocation']);
    
    require_once('detect_mobile_device.php');
    
    } 

$cityop = ($city['id']) ? 'hide' : 'show';

$request_uri = 'index';

if (!$deals = current_deals($city['id'])) {
    
    $deals = current_deals('0');
    
    } 

if ($deals) $_GET['id'] = abs(intval($deals['id']));

require_once('deals.php');

?>