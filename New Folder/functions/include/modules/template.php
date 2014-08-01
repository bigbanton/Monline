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

if (false == defined('DIR_MODULE')) define('DIR_MODULE', DIR_BACKEND . '/install');

if (false == defined('DIR_TEMPLATE')) define('DIR_TEMPLATE', DIR_BACKEND . '/install');

function __parsecall($matches)
{
    
     return '<?php include template("' . $matches[1] . '"); ?>';
    
    } 

function __parse($tFile, $cFile)
{
    
    
    
     $fileContent = false;
    
    
    
     if (!($fileContent = file_get_contents($tFile)))
        
         return false;
    
    
    
     $fileContent = preg_replace('/^(\xef\xbb\xbf)/', '', $fileContent);
    
     $fileContent = preg_replace("/\<\!\-\-\s*\\\$\{(.+?)\}\s*\-\-\>/ies", "__replace('<?php \\1; ?>')", $fileContent);
    
     $fileContent = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\\\ \-\'\,\%\*\/\.\(\)\>\'\"\$\x7f-\xff]+)\}/s", "<?php echo \\1; ?>", $fileContent);
    
     $fileContent = preg_replace("/\\\$\{(.+?)\}/ies", "__replace('<?php echo \\1; ?>')", $fileContent);
    
     $fileContent = preg_replace("/\<\!\-\-\s*\{else\s*if\s+(.+?)\}\s*\-\-\>/ies", "__replace('<?php } else if(\\1) { ?>')", $fileContent);
    
     $fileContent = preg_replace("/\<\!\-\-\s*\{elif\s+(.+?)\}\s*\-\-\>/ies", "__replace('<?php } else if(\\1) { ?>')", $fileContent);
    
     $fileContent = preg_replace("/\<\!\-\-\s*\{else\}\s*\-\-\>/is", "<?php } else { ?>", $fileContent);
    
    
    
     for($i = 0; $i < 5; ++$i) {
        
        $fileContent = preg_replace("/\<\!\-\-\s*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\s*\}\s*\-\-\>(.+?)\<\!\-\-\s*\{\/loop\}\s*\-\-\>/ies", "__replace('<?php if(is_array(\\1)){foreach(\\1 AS \\2=>\\3) { ?>\\4<?php }}?>')", $fileContent);
        
         $fileContent = preg_replace("/\<\!\-\-\s*\{loop\s+(\S+)\s+(\S+)\s*\}\s*\-\-\>(.+?)\<\!\-\-\s*\{\/loop\}\s*\-\-\>/ies", "__replace('<?php if(is_array(\\1)){foreach(\\1 AS \\2) { ?>\\3<?php }}?>')", $fileContent);
        
         $fileContent = preg_replace("/\<\!\-\-\s*\{if\s+(.+?)\}\s*\-\-\>(.+?)\<\!\-\-\s*\{\/if\}\s*\-\-\>/ies", "__replace('<?php if(\\1){?>\\2<?php }?>')", $fileContent);
        
         } 
    
    
    
    $fileContent = preg_replace("#<!--\s*{\s*include\s+([^\{\}]+)\s*\}\s*-->#i", '<?php include template("\\1");?>', $fileContent);
    
     $fileContent = preg_replace("#<!--\s*{\s*fileinclude\s+([^\{\}]+)\s*\}\s*-->#i", '<?php include \\1; ?>', $fileContent);
    
    
    
     $fileContent = str_replace('\"', '"', $fileContent);
    
    
    
     if (!file_put_contents($cFile, $fileContent))
        
         return false;
    
    
    
     return true;
    
    } 

function __replace($string)
{
    
     return str_replace("\\\\", "\\", $string);
    
     return str_replace('\"', '"', $string);
    
    } 

function __template($tFile)
{
    
    $pageURL = ThisPageURL();
    
    $template_folder = (strpos($pageURL , '/business') > 0 || (strpos($pageURL , '/manage/') > 0 && !strpos($pageURL , '/manage/deals/') && !strpos($pageURL , '/manage/coupons/'))) ? DIR_MANAGE : DIR_TEMPLATE;
    
    if ($_GET['show'] == 'template') {
        echo $template_folder;
        exit;
    } 
    
    $tFileN = preg_replace('/\.html$/', '', $tFile);
    
     $tFile = $template_folder . '/' . $tFileN . '.html';
    
     $cFile = DIR_MODULE . '/' . str_replace('/', '_', $tFileN) . '.php';
    
    
    
     if (false === file_exists($tFile)) {
        
        die("Templace File [$tFile] Not Found!");
        
         } 
    
    
    
    if (false === file_exists($cFile)
            
             || @filemtime($tFile) > @filemtime($cFile)) {
        
        __parse($tFile, $cFile);
        
         } 
    
    
    
    return $cFile;
    
    } 
