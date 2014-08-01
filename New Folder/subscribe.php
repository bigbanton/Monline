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

$tip = strval($_GET['tip']);

$refurl = $_POST['refurl'];

if ($_POST) {
    
    $city_id = abs(intval($_POST['city_id']));
    
     ZSubscribe::Create($_POST['email'], $city_id);
    
     cookie_city($city = Table::Fetch('cities', $city_id, 'ename'));
    
     cookieset("subs", "1");
    
    
     die(include template('subscribe_success'));
    
    
    
    
    
    
    } 

include template('subscribe');

?>