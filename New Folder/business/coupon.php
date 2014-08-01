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
 * @version		4.3.3
 * @since 		2011-11-16
 */
ob_start();
require_once(dirname(dirname(__FILE__)) . '/app.php');
$ob_content = ob_get_clean();

need_partner();
$module = 'coupons';
if(isset($_GET['create'])){
$_SESSION['couponid']=$_GET['create'];
exit();
}else{
if ($_GET['idf'] && $_GET['param'] == 'coupon' ) {
	if ($_GET['action'] == 'consumed') {
		if (!abs(intval($INI['system']['partnerdown']))) {
			if (isset($_GET['authcode'])) {
				if(isset($_SESSION['couponid'])){
					$_GET['idf']=$_SESSION['couponid'];
				}
				$coupon = Table::FetchForce('coupon', $_SESSION['couponid']);
				if (strtolower($coupon['secret'])!==strtolower($_GET['authcode'])) {
					Session::Set('error', 'Invalid Authentication Code');
				} else {
					ZCoupon::MarkConsumed($_GET['idf']);
						if(isset($_SESSION['couponid'])){
					unset($_SESSION['couponid']);
			     	}
					Session::Set('notice', TEXT_EN_COUPON_MARKED_AS_USED_EN);
				}
			} else {
				Session::Set('error', 'Authentication is required');
			}
		} else {
			ZCoupon::MarkConsumed($_GET['idf']);
			Session::Set('notice', TEXT_EN_COUPON_MARKED_AS_USED_EN);
		}
	}
	if ($_GET['action'] == 'expired') {
		if (!abs(intval($INI['system']['partnerdown']))) {
			if (isset($_GET['authcode'])) {
					if(isset($_SESSION['couponid'])){
					$_GET['idf']=$_SESSION['couponid'];
				}
				$coupon = Table::FetchForce('coupon', $_GET['idf']);
				if (strtolower($coupon['secret'])!==strtolower($_GET['authcode'])) {
					Session::Set('error', 'Invalid Authentication Code');
				} else {
					ZCoupon::MarkExpired($_GET['idf']);
					if(isset($_SESSION['couponid'])){
					unset($_SESSION['couponid']);
			     	}
					Session::Set('notice', TEXT_EN_COUPON_MARKED_AS_INVALID_EN);
				}
			} else {
				Session::Set('error', 'Authentication is required');
			}
		} else {
			ZCoupon::MarkExpired($_GET['idf']);
			Session::Set('notice', TEXT_EN_COUPON_MARKED_AS_INVALID_EN);
		}
	}

	Utility::Redirect('/business/coupon.php?page=' . $_GET['page'] . '&show=' . $_GET['show']);
}


$now = time();



if (!$partner_id = abs(intval($_SESSION['partner_id']))) {

		$agent = DB::GetTableRow('agent', array(

					'id' => $_SESSION['agent_id'],

		));

		$partner_id = $agent['partnerid'];

}



$login_partner = Table::Fetch('partner', $partner_id);



$title = strval($_GET['title']);

$show = strval($_GET['show']);



if ($show == 'valid') {

	$condition = $t_con = array(

		'partner_id' => $partner_id,

		'consume' => 'N',

		'expire_time > '.$now,

	);

} elseif ($show == 'used') {

	$condition = $t_con = array(

		'partner_id' => $partner_id,

		'consume' => 'Y',

	);

} elseif ($show == 'expired') {

	$condition = $t_con = array(

		'partner_id' => $partner_id,

		'consume' => 'N',

		'expire_time < '.$now,

	);

}

else {

	$condition = $t_con = array(

		'partner_id' => $partner_id,

	);

}





if ($title) { 

	$condition[] = $t_con[] = "id like '%".mysql_escape_string($title)."%' OR secret like '%".mysql_escape_string($title)."%'";

	//$deals = DB::LimitQuery('deals', array(

	//			'condition' => $t_con,

	//			));

	//$deals_ids = Utility::GetColumn($deals, 'id');

	//if ( $deals_ids ) {

	//	$condition['deals_id'] = $deals_ids;

	//} else { $title = null; }

}



$count = Table::Count('coupon', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);



$coupons = DB::LimitQuery('coupon', array(

	'condition' => $condition,

	'order' => 'ORDER BY id DESC',

	'size' => $pagesize,

	'offset' => $offset,

));



$deals_ids = Utility::GetColumn($coupons, 'deals_id');

//$deals = Table::Fetch('deals', $deals_ids);
foreach($coupons as $coupon){
	$table=$coupon['isinsta']==1?'insta':'deals';
$deals[$coupon['deals_id']] = Table::Fetch($table, $coupon['deals_id']);
}




$user_ids = Utility::GetColumn($coupons, 'user_id');

$users = Table::Fetch('user', $user_ids);



include template('business_coupon');

}