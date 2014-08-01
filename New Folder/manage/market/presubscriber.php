<?php

/**
 * //License information must not be removed.
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

if ($_POST) {
    if ($_POST['sub_on'] == 'on') {
        $file = 'saveSubscribers.csv';
         $filename = DIR_BACKEND . "/presubscribers/$file";
         header("Cache-Control: public");
         header("Content-Description: File Transfer");
         header('Content-disposition: attachment; filename=' . basename($filename));
         header("Content-Type: application/csv");
         header("Content-Transfer-Encoding: binary");
         header('Content-Length: ' . filesize($filename));
         readfile($filename);
         exit;
         } else {
        $file = 'saveSubscribers.csv';
         $filename = DIR_BACKEND . "/presubscribers1/$file";
         header("Cache-Control: public");
         header("Content-Description: File Transfer");
         header('Content-disposition: attachment; filename=' . basename($filename));
         header("Content-Type: application/csv");
         header("Content-Transfer-Encoding: binary");
         header('Content-Length: ' . filesize($filename));
         readfile($filename);
         exit;
        
         } 
    
    } 

include template('manage_market_presubscriber');
