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

$n = strval($_GET['n']);

$v = strval($_GET['v']);

if ('signupemail' == $n) {
    
    $u = Table::Fetch('user', $v, 'email');
    
     if ($u) Output::Json(null, 1);
    
     Output::Json(0);
    
    } 

elseif ('signupname' == $n) {
    
    $u = Table::Fetch('user', $v, 'username');
    
     if ($u) Output::Json(null, 1);
    
     Output::Json(0);
    
    } 

