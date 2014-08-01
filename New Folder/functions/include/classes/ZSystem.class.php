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

class ZSystem

 {
    
    static public function GetINI()
    {
        
         global $INI;
        
         $INI = Config::Instance('php');
        
         $SYS = Table::Fetch('system', 1);
        
         $SYS = Utility::ExtraDecode($SYS['value']);
        
         $INI = Config::MergeINI($INI, $SYS);
        
         $INI = ZSystem::WebRoot();
        
         return self::BuildINI($INI);
        
         } 
    
    
    
    static public function GetUnsetINI($ini)
    {
        
         unset($ini['db']);
        
         unset($ini['webroot']);
        
         unset($ini['memcache']);
        
         return $ini;
        
         } 
    
    
    
    static public function GetSaveINI($ini)
    {
        
         return array(
            
            'db' => $ini['db'],
            
             'memcache' => $ini['memcache'],
            
             'webroot' => $ini['webroot'],
            
            );
        
         } 
    
    
    
    
    
    static private function WebRoot()
    {
        
         global $INI;
        
         if (defined('BASE_REF')) {
            
            define('WEB_ROOT', BASE_REF);
            
             return $INI;
            
             } 
        
        
/**
         * validator
         */
        
        $script_name = $_SERVER['SCRIPT_NAME'];
        
         if (preg_match('#^(.*)/app.php$#', $script_name, $m)) {
            
            $INI['webroot'] = $m[1];
            
             save_config('php');
            
             } 
        
        
        
        if (isset($INI['webroot'])) {
            
            define('BASE_REF', $INI['webroot']);
            
             define('WEB_ROOT', BASE_REF);
            
             } else {
            
            $document_root = $_SERVER['DOCUMENT_ROOT'];
            
             $docroot = rtrim(str_replace('\\', '/', $document_root), '/');
            
             if (!$docroot) {
                
                $script_filename = $_SERVER['SCRIPT_FILENAME'];
                
                 $script_filename = str_replace('\\', '/', $script_filename);
                
                 $script_name = $_SERVER['SCRIPT_NAME'];
                
                 $script_name = str_replace('\\', '/', $script_name);
                
                 $lengthf = strlen($script_filename);
                
                 $lengthn = strlen($script_name);
                
                 $length = $lengthf - $lengthn;
                
                 $docroot = rtrim(substr($script_filename, 0, $length), '/');
                
                 } 
            
            $webroot = trim(substr(BASE_FOLDER, strlen($docroot)), '\\/');
            
             define('BASE_REF', $webroot ? "/{$webroot}" : '');
            
             define('WEB_ROOT', BASE_REF);
            
             } 
        
        return $INI;
        
         } 
    
    
    
    static private function BuildINI($ini)
    {
        
         $host = $_SERVER['HTTP_HOST'];
        
         $ini['system']['wwwprefix'] = "http://{$host}" . BASE_REF;
        
         $ini['system']['imgprefix'] = "http://{$host}" . BASE_REF;
        
         if (!$ini['system']['sitename']) {
            
            $ini['system']['sitename'] = 'Your website name';
            
             } 
        
        if (!$ini['system']['sitetitle']) {
            
            $ini['system']['sitetitle'] = 'Website title';
            
             } 
        
        if (!$ini['system']['abbreviation']) {
            
            $ini['system']['abbreviation'] = 'Abbreviation';
            
             } 
        
        if (!$ini['system']['couponname']) {
            
            $ini['system']['couponname'] = 'Coupon';
            
             } 
        
        if (!$ini['system']['currency']) {
            
            $ini['system']['currency'] = '$';
            
             } 
        
        return $ini;
        
         } 
    
    
    
    static public function GetThemeList()
    {
        
         $root = WWW_ROOT . '/themes/theme';
        
         $dirs = scandir($root);
        
         $themelist = array('default' => 'default',);
        
         foreach($dirs AS $one) {
            
            if (strpos($one, '.') === 0) continue;
            
             $onedir = $root . '/' . $one;
            
             if (is_dir($onedir)) $themelist[$one] = $one;
            
             } 
        
        return $themelist;
        
         } 
    
    
    
    static public function GetTemplateList()
    {
        
         $root = DIR_BACKEND . '/templates';
        
         $dirs = scandir($root);
        
         $templatelist = array();
        
         foreach($dirs AS $one) {
            
            if (strpos($one, '.') === 0 || $one == '_default') continue;
            
             $onedir = $root . '/' . $one;
            
             if (is_dir($onedir)) $templatelist[$one] = $one;
            
             } 
        
        return $templatelist;
        
         } 
    
    } 

