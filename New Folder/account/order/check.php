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
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_login();

$id = abs(intval($_GET['id']));
$order = Table::Fetch('order', $id);
if (!$order) {
    die('404 Not Found');
} 

$dbname = ($order['isinsta']) ? 'insta' : 'deals';
$deals = Table::Fetch($dbname, $order['deals_id']);
$deals['state'] = ($order['isinsta']) ? 'success' : deals_state($deals);

if ($deals['state'] != 'none') {
    if ($deals['state'] != 'success') {
        Utility::Redirect(BASE_REF . "/deals.php?id=" . $id . "&isinsta=" . $_REQUEST['isinsta']);
         } 
    } 

if ($order['state'] == 'unpay') {
    if ($INI['paypal'] && $order['service'] == 'paypal') {
        $ordercheck['paypal'] = 'checked';
         } 
    else if ($INI['paypal']) {
        $ordercheck['paypal'] = 'checked';
         } 
    die(include template('order_check'));
    } 

Utility::Redirect(BASE_REF . "/account/order/view.php?id={$id}&isinsta={$order['isinsta']}");
