<?php

/**

 * //License information must not be removed.

 * PHP version 5.2x

 *

 * @category	### Gripsell ###

 * @package		### Advanced ###

 * @arch		### Secured  ###

 * @author 		Development Team, Gripsell Technologies & Consultancy Services

 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}

 * @license		http://www.gripsell.com Clone Portal

 * @version		4.3.2

 * @since 		2011-08-23

 */
ob_start();
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$ob_content = ob_get_clean();

need_login();
$order_id = $id = strval(intval($_GET['id']));
if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
	die('404 Not Found');
}



$dbname = ($order['isinsta'] || $_REQUEST['isinsta']) ? 'insta' : 'deals';


if ( $order['user_id'] != $login_user['id']) {
	Utility::Redirect( BASE_REF . "/deals.php?id={$order['deals_id']}");
}
if ( $order['state']=='unpay') {
	Utility::Redirect( BASE_REF . "/deals.php?id={$order['deals_id']}");
}

$deals1 = Table::FetchForce($dbname, $order['deals_id']);
if($order['option_price']>0){
$deals1['deals_price']=$order['option_price'];
}
$partner = Table::Fetch('partner', $order['partner_id']);
$express = ($deals1['delivery']=='express');

if ( $deals1['delivery'] == 'coupon' ) {
	$cc = array(
			'user_id' => $login_user['id'],
			'deals_id' => $order['deals_id'],
			'order_id' => $order['id'],
			);
	$coupons = DB::LimitQuery('coupon', array(
				'condition' => $cc,
				));
}

include template('order_view');
