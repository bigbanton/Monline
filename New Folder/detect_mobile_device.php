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

$mobile_browser = '0';

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    
    $mobile_browser++;
    
    } 

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    
    $mobile_browser++;
    
    } 

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));

$mobile_agents = array(
    
    'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
    
     'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
    
     'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
    
     'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
    
     'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
    
     'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
    
     'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
    
     'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
    
     'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');

if (in_array($mobile_ua, $mobile_agents)) {
    
    $mobile_browser++;
    
    } 

if (strpos(strtolower($_SERVER['ALL_HTTP']), 'OperaMini') > 0) {
    
    $mobile_browser++;
    
    } 

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
    
    $mobile_browser = 0;
    
    } 

if ($mobile_browser > 0) {
    
    Session::Set('Browse', 'Mobile');
    
     header('location: ' . MOBILE_VERSION_URL);
    
    } else {
    
    Session::Set('Browse', 'Computer');
    
    } 

?>