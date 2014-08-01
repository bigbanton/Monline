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

$daytime = time();
need_login();
$condition = array( 'user_id' => $login_user_id,);
$selector = strval($_GET['s']);

if ( $selector == 'index' ) {
}
else if ( $selector == 'unpay' ) {
	$condition['state'] = 'unpay';
}
else if ( $selector == 'pay' ) {
	$condition['state'] = 'pay';
}

$count = Table::Count('deals', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$livecounter = 0;
$missedcounter = 0;

foreach($orders AS $id=>$one){
	$deals = Table::FetchForce('deals', $one['deals_id']);
	

	if ($one['state']=='unpay' && $deals["end_time"] < $daytime) {
		$one['picclass'] = 'no';
	} else {
		$one['picclass'] = 'yes';
	}
	
	$orders[$id] = $one;
}


$deals_ids = Utility::GetColumn($orders, 'deals_id');
$deals = Table::Fetch('deals', $deals_ids);
$insta = Table::Fetch('insta', $deals_ids);

include template('order_index');