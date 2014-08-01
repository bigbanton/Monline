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
$pages = array(
    
    // 'fn_tour' => 'Tour ' . $INI['system']['abbreviation'],
    'fn_faqs' => 'FAQ',
    
     'fn_TGS' => 'What is ' . $INI['system']['abbreviation'],
    
    // 'fn_api' => 'Develope API',
    // 'about_contact' => 'Contact',
     'about_us' => 'About ' . $INI['system']['abbreviation'],
    
     'about_job' => 'Job',
    
     'about_terms' => 'Terms of Service',
    
     'about_privacy' => 'Privacy',
    
    );

$langcondition = array('deleted' => '0', 'status' => 'enabled');

$languages = DB::LimitQuery('language', array(
        
        'condition' => $langcondition,
        
         'order' => 'ORDER BY id ASC',
        
        ));

$page_id = strval($_GET['id']);

if ($page_id && !in_array($page_id, array_keys($pages))) {
    
    Utility::Redirect(BASE_REF . "/manage/system/page.php");
    
    } 

// $n = Table::Fetch('templates', $page_id);
foreach ($languages as $language) {
    
    $arrstr = $arrstr . "\"lang_id = " . $language['id'] . "\",\n";
    
    } 

$n = DB::LimitQuery('templates', array('condition' => array('page_id' => $page_id)));

foreach ($languages as $language) {
    
    foreach ($n as $one) {
        
        if ($one['lang_id'] == $language['id']) $html[$language['code']] = $one['value'];
        
         } 
    
    } 

if ($_POST) {
    
    foreach ($languages as $language) {
        
        $_POST['value' . $language['code']] = stripslashes($_POST['value' . $language['code']]);
        
        
        
         if ($html[$language['code']]) {
            
            DB::Update('templates', array('page_id' => $page_id, 'lang_id' => $language['id'],), array('value' => $_POST['value' . $language['code']],));
            
             } else {
            $templates = Table::Fetch('templates', $page_id, 'page_id');
             if (!$templates) {
                $page = array('page_id', 'value', 'lang_id');
                
                 $pagearr['value'] = $_POST['value' . $language['code']];
                
                 $pagearr['page_id'] = $page_id;
                
                 $pagearr['lang_id'] = $language['id'];
                
                 DB::Insert('templates', $pagearr);
                 } 
            } 
        
        } 
    
    Session::Set('notice', "The page '{$pages[$page_id]}' has been updated.");
    
     Utility::Redirect(BASE_REF . "/manage/system/page.php?id={$page_id}");
    
    } 

include template('manage_system_page');

