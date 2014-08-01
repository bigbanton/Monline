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

$fileName = $_GET['img'];

$ext = substr($fileName, strrpos($fileName, '.') + 1);

// be sure to have an error image
if (!file_exists(DIR_BACKEND . '/themes' . $fileName)) $fileName = 'noimage.jpg';

// $ob_content = ob_get_clean();
header('Content-Type: image/jpg;');

header("Cache-Control: private, max-age=10800, pre-check=10800");

header("Pragma: private");

header("Expires: " . date(DATE_RFC822, strtotime(" 2 day")));

// the browser will send a $_SERVER['HTTP_IF_MODIFIED_SINCE'] if it has a cached copy
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    
    // if the browser has a cached version of this image, send 304
    header('Last-Modified: ' . $_SERVER['HTTP_IF_MODIFIED_SINCE'], true, 304);
    
     exit;
    
    } 

ob_clean();

flush(); //Free up PHP Buffer now

if (@readfile(DIR_BACKEND . '/themes' . $fileName) === false) {
    
    echo @file_get_contents(DIR_BACKEND . '/themes' . $fileName);
    
    } 
