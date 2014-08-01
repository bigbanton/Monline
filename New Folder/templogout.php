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

/**
 * for rewrite or iis rewrite
 */

if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
    
    $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
    
    } else if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
    
    $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
    
    } 

/**
 * end
 */

if (isset($_SERVER['REQUEST_URI'])) {
    
    ob_start();
    
    } 

session_start();

$AJAX = ('XMLHttpRequest' == @$_SERVER['HTTP_X_REQUESTED_WITH']);

if (false == $AJAX) {
    
    header('Content-Type: text/html; charset=UTF-8;');
    
    } else {
    
    header("Cache-Control: no-store, no-cache, must-revalidate");
    
    } 

require_once('facebook/facebook.php');

require_once('facebook/configuration.php');

$facebook_api_key = APIKEY;

$facebook_secret = SECRET;

$fb = new Facebook(APIKEY, SECRET);

$uid = $fb->get_loggedin_user();

function destroyCookies ($fb)
{
    
     $apiKey = APIKEY;
    
    
    
     $cookies = array('user', 'session_key', 'expires', 'ss');
    
     foreach ($cookies as $name)
    
     {
        
        setcookie($apiKey . '_' . $name, false, time() - 3600);
        
         unset($_COOKIE[$apiKey . '_' . $name]);
        
         } 
    
    
    
    setcookie($apiKey, false, time() - 3600);
    
     unset($_COOKIE[$apiKey]);
    
     session_destroy();
    
     $redirect = dirname($_SERVER['HTTP_REFERER']);
    
     if (strstr($redirect, 'account')) {
        
        $redirect = substr($redirect, 0, -8);
        
         } 
    
    
/**
     * if($fb->get_loggedin_user()) {
     * 
     * header("location:{$redirect}/templogout.php");
     * 
     * } else {
     */
    
    // header("location:{$redirect}");
    // }
    exit;
    
    } 

destroyCookies($fb);

echo '<pre>';

print_r($_COOKIE);

echo $fb->get_loggedin_user();

exit;

$fb->logout($redirect . '/account/logout.php');

// header("location:".$redirect);
exit();

?>