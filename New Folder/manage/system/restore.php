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

need_auth('admin');
$module = 'system';
$db_name = $INI['db']['name'];

$tables = DB::GetQueryResult("SHOW TABLE STATUS FROM `{$db_name}`", false);

$backupdir = DIR_BACKEND . '/backup';

$handle = opendir($backupdir);

$bs = array();

while ($file = readdir($handle)) {
    
    if (eregi("^[0-9]{4}_[0-9]{2}_[0-9]{2}_[A-Z]{4}([0-9a-zA-Z_]+)(\.sql)$", $file))
        
         $bs[$file] = $file;
    
    } 

krsort($bs);

closedir($handle);

$action = strval($_REQUEST['action']);

if ($action == "restore") {
    
    if ($_POST['restorefrom'] == "server") {
        
        $serverfile = strval($_POST['serverfile']);
        
         if (!$serverfile) {
            
            Session::Set('error', "Select a valid backup file.");
            
             reload();
            
             } 
        
        
        
        if (!eregi("_v[0-9]+", $serverfile)) {
            
            $filename = $backupdir . '/' . $serverfile;
            
             if (backup_import($filename)) {
                
                Session::Set('notice', "Backup file {$serverfile} was successfully imported to the database");
                
                 } 
            
            else {
                
                Session::Set('error', "Backup file {$serverfile} failed to be imported");
                
                 } 
            
            reload();
            
             } else {
            
            $filename = $backupdir . '/' . $serverfile;
            
             if (true === backup_import($filename)) {
                
                Session::Set('notice', "{$serverfile} was imported to the database");
                
                 } 
            
            else {
                
                Session::Set('error', "{$serverfile} failed to be imported");
                
                 reload();
                
                 } 
            
            $voltmp = explode("_v", $serverfile);
            
             $volname = $voltmp[0];
            
             $volnum = explode(".sq", $voltmp[1]);
            
             $volnum = intval($volnum[0]) + 1;
            
             $nextfile = $volname . "_v" . $volnum . ".sql";
            
             if (file_exists("{$backupdir}/{$nextfile}")) {
                
                Session::Set('notice', "System will automatically import next section of the multiple volume backup in 3 seconds: file {$nextfile}");
                
                 Session::Set('nextfile', $nextfile);
                
                 _retore_script();
                
                 } else {
                
                Session::Set('notice', "All of this volume backup has been  imported.");
                
                 } 
            
            reload();
            
             } 
        
        } 
    
    
    
    if ($_POST['restorefrom'] == "localpc") {
        
        switch ($_FILES['myfile']['error']) {
        
        case 1:
        
         case 2:
            
             $msgs = "Your file is bigger than the server upload limit. Upload failed.";
            
             break;
        
         case 3:
            
             $msgs = "Backup files uploaded from your computer is not complete";
            
             break;
        
         case 4:
            
             $msgs = "Uploading backup files from your computer failed.";
            
             break;
        
         case 0:
            
             break;
            
             } 
        
        if ($msgs) {
        
        Session::Set('error', $msgs);
        
         reload();
        
         } 
    
    if (true === backup_import($_FILES['myfile']['tmp_name'])) {
        
        Session::Set('notice', "Local backup file uploading succeeded.");
        
         } else {
        
        Session::Set('error', "Local backup file failed to be imported to the database.");
        
         } 
    
    reload();
    
     } 

if ($_SESSION['nextfile']) {
    
    $serverfile = strval($_SESSION['nextfile']);
    
     $filename = $backupdir . '/' . $serverfile;
    
     if (true === backup_import($filename)) {
        
        Session::Set('notice', "{$serverfile} has been imported to the database");
        
         } 
    
    else {
        
        Session::Set('error', "{$serverfile} failed to be imported");
        
         reload();
        
         } 
    
    $voltmp = explode("_v", $serverfile);
    
     $volname = $voltmp[0];
    
     $volnum = explode(".sq", $voltmp[1]);
    
     $volnum = intval($volnum[0]) + 1;
    
     $nextfile = $volname . "_v" . $volnum . ".sql";
    
     if (file_exists("{$backupdir}/{$nextfile}")) {
        
        Session::Set('notice', "System will automatically import next section of the multiple volume backup in 3 seconds:file {$nextfile}");
        
         Session::Set('nextfile', $nextfile);
        
         _retore_script();
        
         } else {
        
        Session::Set('notice', "The multiple vulume backup has all been imported.");
        
         } 
    
    reload();
    
     } 

} 

$show = array();

$show[] = "Restoration will replace your existing data. Any changes might be lost.";

$show[] = "Restore functions supports files exported by Gripsell script. Files exported by other softwares may cause error.";

$show[] = "The maximum size of data to be restored locally is dependent on your PHP settings.";

$show[] = "Other data files may or may not be imorted by the system.";

include template('manage_system_restore');

function _retore_script()
{

 $script = "<meta http-equiv='refresh' content='3; url=restore.php?action=restore' />" ;

 Session::Set('script', $script);

} 

function reload()
{

 Utility::Redirect(WEB_ROOT . '/manage/system/restore.php');

} 
