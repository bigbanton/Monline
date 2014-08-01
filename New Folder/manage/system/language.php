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
$module = 'system';
 $system = Table::Fetch('system', 1);

 include_once(dirname(dirname(__FILE__)) . '/config.php');

 $tmpfilename = DIR_BACKEND . '/data/cache/';

 $langcondition = array('deleted' => '0',);

 $languages = DB::LimitQuery('language', array(
        
        'condition' => $langcondition,
        
         'order' => 'ORDER BY id ASC',
        
        ));

 if ($_POST["addlang"]) {
    
    $path = DIR_BACKEND . '/data/cache' . "/" . $strCsvFile . ".lng";
    
    
    
     if (!trim($_POST["addlangname"])) {
        
        Session::Set('error', 'Langauge name is required');
        
         Utility::Redirect('language.php');
        
         } 
    
    
    
    if (!trim($_POST["addlangcode"])) {
        
        Session::Set('error', 'Langauge code is required');
        
         Utility::Redirect('language.php');
        
         } 
    
    
    
    if (!preg_match("/^[a-zA-Z]+$/i", $_POST["addlangcode"])) {
        
        Session::Set('error', 'Langauge code cannot contain special characters');
        
         Utility::Redirect('language.php');
        
         } 
    
    
    
    $_POST["addlangcode"] = strtolower($_POST["addlangcode"]);
    
    
    
     if (DB::GetTableRow('language', array('OR' => array('code' => $_POST["addlangcode"], 'name' => trim($_POST["addlangname"]))))) {
        
        
        
        Session::Set('error', 'Langauge name or code already used');
        
        
        
         } else {
        
        
        
        $arrLang = array(
            
            'name' => $_POST["addlangname"],
            
             'code' => strtolower($_POST["addlangcode"]),
            
             'status' => ($_POST["addlangstatus"])?'enabled':'disabled',
            
            );
        
        
        
         if (file_exists(DIR_BACKEND . '/data/cache/sample.lng')) copy(DIR_BACKEND . '/data/cache/sample.lng', DIR_BACKEND . '/data/cache/' . $_POST["addlangcode"] . '.lng');
        
        
        
         if (DB::Insert('language', $arrLang)) Session::Set('notice', 'New language successfully added');
        
        
        
         } 
    
    Utility::Redirect('language.php');
    
     } elseif ($_POST["updatelangstatus"]) {
    
    
    
    foreach ($languages as $language) {
        
        
        
        $arrLangs = $_POST['language'];
        
        
        
         $enabled = "disabled";
        
         foreach ($arrLangs as $key => $langenable) {
            
            if ($langenable == $language['id'] || $language['code'] == 'en') $enabled = "enabled";
            
             } 
        
        DB::Update('language', $language['id'], array(
                
                'status' => $enabled,
                
                ), 'id');
        
         } 
    
    
    
    Session::Set('notice', 'Language status has been updated');
    
    
    
     Utility::Redirect('language.php');
    
    
    
     } elseif ($_POST["editlang"]) {
    
    // echo $_POST["id"]; exit;
    DB::Update('language', $_POST["id"], array(
            
            'name' => utf8_encode($_POST["newname"]),
            
            ), 'id');
    
    
    
     echo utf8_encode($_POST["newname"]);
    
     exit();
    
    
    
     } elseif ($_GET["deletelang"] && $_GET['action'] = 'do' && $_GET['do'] == 'delete') {
    
    
    
    if (DB::Update('language', $_GET['langID'], array(
                
                'deleted' => '1',
                
                ), 'id')) Session::Set('notice', 'Language successfully removed.');
    
    
    
     Utility::Redirect('language.php');
    
     } 

$languages = DB::LimitQuery('language', array(
        
        'condition' => $langcondition,
        
         'order' => 'ORDER BY id ASC',
        
        ));

 $strCsvFile = $_GET["file"];

 $strLetter = $_GET["letter"];

 if (is_dir($tmpfilename)) {
    
    $strLangFiles = ZLanguageTranslate::getCSVFiles($tmpfilename);
    
     } 

include template('manage_system_language');

?>