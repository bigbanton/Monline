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



need_dealer();



$action = strval($_GET['action']);

$id = abs(intval($_GET['id']));



if ( 'orderrefund' == $action) {

	$order = Table::Fetch('order', $id);

	$rid = strtolower(strval($_GET['rid']));

	if ( $rid == 'credit' ) {

		ZFlow::CreateFromRefund($order);

	} else {

		Table::UpdateCache('order', $id, array('state' => 'unpay'));

	}

	/* deals -- */

	$deals = Table::Fetch('deals', $order['deals_id']);

	deals_state($deals);

	if ( $deals['state'] != 'failure' ) {

		$minus = $deals['conduser'] == 'Y' ? $order['quantity'] :1;

		Table::UpdateCache('deals', $deals['id'], array(

					'now_number' => array( "now_number - {$minus}", ),

		));

	}

	/* card refund */

	if ( $order['card_id'] ) {

		Table::UpdateCache('card', $order['card_id'], array(

			'consume' => 'N',

			'deals_id' => 0,

			'order_id' => 0,

		));

	}

	/* coupons */

	if ( in_array($deals['delivery'], array('coupon', 'pickup') )) {

		$coupons = Table::Fetch('coupon', array($order['id']), 'order_id');

		foreach($coupons AS $one) Table::Delete('coupon', $one['id']);

	}



	/* order update */

	Table::UpdateCache('order', $id, array(

				'card' => 0, 

				'card_id' => '',

				'express_id' => 0,

				'express_no' => '',

				));

	Session::Set('notice', TEXT_EN_REFUND_SUCCESSFULLY_EN);

	json(null, 'refresh');

}

elseif ( 'orderremove' == $action) {

	$order = Table::Fetch('order', $id);

	if ( $order['state'] != 'unpay' ) {

		json('Paid already, cannot delete', 'alert');

	}

	/* card refund */

	if ( $order['card_id'] ) {

		Table::UpdateCache('card', $order['card_id'], array(

			'consume' => 'N',

			'deals_id' => 0,

			'order_id' => 0,

		));

	}

	Table::Delete('order', $order['id']);

	Session::Set('notice', "Delete order {$order['id']} OK");

	json(null, 'refresh');

}

else if ( 'ordercash' == $action ) {

	$order = Table::Fetch('order', $id);

	ZOrder::CashIt($order);

	$user = Table::Fetch('user', $order['user_id']);

	Session::Set('notice', "Cash payment OK. User: {$user['email']}");

	json(null, 'refresh');

}
//Add the patch for calculation of total deal ammount
else if ( 'dealsdetail' == $action) {



	$deals = Table::Fetch('deals', $id);

	$partner = Table::Fetch('partner', $deals['partner_id']);



	$paycount = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,
		
		'isinsta'=>0,

	));

	$buycount = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,
		
		'isinsta'=>0,

	), 'quantity');

	$onlinepay = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

	), 'money');

	$creditpay = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,
		
		'isinsta' => 0,

	), 'credit');

	$cardpay = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

	), 'card');

	$couponcount = Table::Count('coupon', array(

		'deals_id' => $id,

	));

	$deals['state'] = deals_state($deals);

	$subcount = Table::Count('subscribe', array( 

				'city_id' => $deals['city_id'],

				));



	/* send deals subscribe mail */	

	$deals['noticesubscribe'] = ($deals['close_time']==0&&is_manager());

	/* send success coupon */

	$deals['noticesms'] = ($deals['delivery']!='express')&&(in_array($deals['state'], array('success', 'soldout')))&&is_manager();

	/* dealscoupon */

	$deals['dealscoupon'] = ($deals['noticesms']&&$buycount>$couponcount);

	$deals['needline'] = ($deals['noticesms']||$deals['noticesubscribe']||$deals['dealscoupon']);



	$html = render('manage_tsg_dialog_dealsdetail');

	json($html, 'dialog');

}

else if ( 'dealsremove' == $action) {

	$deals = Table::Fetch('deals', $id);

	$order_count = Table::Count('order', array(

		'deals_id' => $id,

		'state' => 'pay',

	));

	if ( $order_count > 0 ) {

		json('This deal is over or has buyers, can not delete it', 'alert');

	}

	Zdeals::Deletedeals($id);



	/* remove coupon */

	$coupons = Table::Fetch('coupon', array($id), 'deals_id');

	foreach($coupons AS $one) Table::Delete('coupon', $one['id']);

	/* remove order */

	$orders = Table::Fetch('order', array($id), 'deals_id');

	foreach($orders AS $one) Table::Delete('order', $one['id']);

	/* end */



	Session::Set('notice', "Deal {$id} is deleted successfully!");

	json(null, 'refresh');

}

else if ( 'instadetail' == $action) {



	$deals = Table::Fetch('insta', $id);

	$partner = Table::Fetch('partner', $deals['partner_id']);



	$paycount = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

		'isinsta' => 1,

	));

	$buycount = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

		'isinsta' => 1,

	), 'quantity');

	$onlinepay = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

		'isinsta' => 1,

	), 'money');

	$creditpay = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

		'isinsta' => 1,

	), 'credit');

	$cardpay = Table::Count('order', array(

		'state' => 'pay',

		'deals_id' => $id,

		'isinsta' => 1,

	), 'card');

	$couponcount = Table::Count('coupon', array(

		'deals_id' => $id,

		'isinsta' => 1,

	));

	$deals['state'] = deals_state($deals);

	$subcount = Table::Count('subscribe', array( 

				'city_id' => $deals['city_id'],

				));



	/* dealscoupon */

	$deals['dealscoupon'] = ($deals['noticesms']&&$buycount>$couponcount);

	$deals['needline'] = ($deals['noticesms']||$deals['noticesubscribe']||$deals['dealscoupon']);



	$html = render('manage_tsg_dialog_dealsdetail');

	json($html, 'dialog');

}

else if ( 'instaremove' == $action) {

	$deals = Table::Fetch('insta', $id);

	$order_count = Table::Count('order', array(

		'deals_id' => $id,

		'state' => 'pay',

		'isinsta' => 1,

	));

	if ( $order_count > 0 ) {

		json('This deal is over or has buyers, can not delete it', 'alert');

	}

	Zdeals::DeleteInsta($id);



	/* remove coupon */

	$coupons = Table::Fetch('coupon', array($id), 'deals_id');

	foreach($coupons AS $one) if ($one['isinsta']==1) Table::Delete('coupon', $one['id']);

	/* remove order */

	$orders = Table::Fetch('order', array($id), 'deals_id');

	foreach($orders AS $one) if ($one['isinsta']==1) Table::Delete('order', $one['id']);

	/* end */



	Session::Set('notice', "Insta deal {$id} is deleted successfully!");

	json(null, 'refresh');

}

else if ( 'cardremove' == $action) {

	$id = strval($_GET['id']);

	$card = Table::Fetch('card', $id);

	if (!$card) json('Dont have this coupon', 'alert');

	if ($card['consume']=='Y') { json('Coupon is used, cannot delete', 'alert'); }

	Table::Delete('card', $id);

	Session::Set('notice', "Coupon {$id} is deleted!");

	json(null, 'refresh');

}

else if ( 'userview' == $action) {

	$user = Table::Fetch('user', $id);

	$html = render('manage_tsg_dialog_user');

	json($html, 'dialog');

}

else if ( 'usermoney' == $action) {

	$user = Table::Fetch('user', $id);

	$money = intval($_GET['money']);

	if ( ZFlow::CreateFromStore($id, $money) ) {

		$action = ($money>0) ? 'Topup offline' : 'Withdraw';

		$money = abs($money);

		json(array(

					array('data' => "{$action}{$money} Dollars OK", 'type'=>'alert'),

					array('data' => null, 'type'=>'refresh'),

				  ), 'mix');

	}

	json('Topup failed', 'alert'); 

}

else if ( 'orderexpress' == $action ) {

	$express_id = abs(intval($_GET['eid']));

	$express_no = strval($_GET['nid']);

	if (!$express_id) $express_no = null;

	Table::UpdateCache('order', $id, array(

		'express_id' => $express_id,

		'express_no' => $express_no,

	));

	json(array(

				array('data' => "Modify delivery information OK", 'type'=>'alert'),

				array('data' => null, 'type'=>'refresh'),

			  ), 'mix');

}

else if ( 'orderview' == $action) {

	$order = Table::Fetch('order', $id);

	$user = Table::Fetch('user', $order['user_id']);

	$table=$order['isinsta']==1?'insta':'deals';
	$deals = Table::Fetch($table, $order['deals_id']);

	if ($deals['delivery'] == 'express') {

		$option_express = option_category('express');

	}

	$payservice = array(

		'paypal' => 'PayPal',

		'alipay' => 'Alipay',

		'tenpay' => 'tenpay',

		'chinabank' => 'ChinaBank',

		'credit' => 'Credit',

		'cash' => 'Cash',

	);

	$paystate = array(

		'unpay' => '<font color="green">Unpaid</font>',

		'pay' => '<font color="red">Paid</font>',

	);

	$option_refund = array(

		'credit' => 'Refund to user account',

		'online' => 'Refund already',

	);

	$html = render('manage_tsg_dialog_orderview');

	json($html, 'dialog');

}

else if ( 'inviteok' == $action ) {

	need_auth('admin');

	$invite = Table::Fetch('invite', $id);

	if (!$invite || $invite['pay']!='N') {

		json('Illegal operation', 'alert');

	}

	if(!$invite['deals_id']) {

		json('Did not buy anything, can not get rebate', 'alert');

	}

	$deals = Table::Fetch('deals', $invite['deals_id']);

	$deals_state = deals_state($deals);

	if (!in_array($deals_state, array('success', 'soldout'))) {

		json('Only a valid deal can get rebate.', 'alert');

	}

	Table::UpdateCache('invite', $id, array(

				'pay' => 'Y', 

				'admin_id'=>$login_user_id,

				));

	$invite = Table::FetchForce('invite', $id);

	ZFlow::CreateFromInvite($invite);

	Session::Set('notice', TEXT_EN_INVITATION_REBATE_OPERATION_IS_DONE_EN);

	json(null, 'refresh');

}

else if ( 'inviteremove' == $action ) {

	need_auth('admin');

	Table::Delete('invite', $id);

	Session::Set('notice', TEXT_EN_ILLEGAL_INVITATIONS_DELETED_EN);

	json(null, 'refresh');

}

else if ( 'subscriberemove' == $action ) {

	$subscribe = Table::Fetch('subscribe', $id);

	if ($subscribe) {

		ZSubscribe::Unsubscribe($subscribe);

		Session::Set('notice', "Email: {$subscribe['email']} unsubscribed successfully");

	}

	json(null, 'refresh');

}

else if ( 'partnerremove' == $action ) {

	$partner = Table::Fetch('partner', $id);

	$count = Table::Count('deals', array('partner_id' => $id) );

	if ($partner && $count==0) {

		Table::Delete('partner', $id);

		Session::Set('notice', "Partner {$id} deleted");

		json(null, 'refresh');

	}

	if ( $count > 0 ) {

		json('Partner has deal, cannot delete', 'alert'); 

	}

	json('Partner delete error.', 'alert'); 

}

else if ( 'noticesms' == $action ) {

	$nid = abs(intval($_GET['nid']));

	$now = time();

	$deals = Table::Fetch('deals', $id);

	$condition = array( 'deals_id' => $id, );

	$coups = DB::LimitQuery('coupon', array(

				'condition' => $condition,

				'order' => 'ORDER BY id ASC',

				'offset' => $nid,

				'size' => 1,

				));

	if ( $coups ) {

		foreach($coups AS $one) {

			$nid++;

			sms_coupon($one);

		}

		json("X.misc.noticesms({$id},{$nid});", 'eval');

	} else {

		json($INI['system']['couponname'].' is sent ', 'alert');

	}

}

else if ( 'noticesubscribe' == $action ) {

	$nid = abs(intval($_GET['nid']));

	$now = time();

	$deals = Table::Fetch('deals', $id);

	$partner = Table::Fetch('partner', $deals['partner_id']);

	$city = Table::Fetch('cities', $deals['city_id']);

	$condition = array( 'city_id' => $deals['city_id'], );

	$subs = DB::LimitQuery('subscribe', array(

				'condition' => $condition,

				'order' => 'ORDER BY id ASC',

				'offset' => $nid,

				'size' => 1,

				));

	if ( $subs ) {

		foreach($subs AS $one) {

			$nid++;

			try {

				ob_start();

				mail_subscribe($city, $deals, $partner, $one);

				$v = ob_get_clean();

				if ($v) throw new Exception($v);

			}catch(Exception $e) { 

				json(array(

							array('data' => $e->getMessage(), 'type'=>'alert'),

							array('data' => "X.misc.noticenext({$id},{$nid});", 'eval'),

						  ), 'mix');

			}

			$cost = time() - $now;

			if ( $cost >= 20 ) {

				json("X.misc.noticenext({$id},{$nid});", 'eval');

			}

		}

		json("X.misc.noticenext({$id},{$nid});", 'eval');

	} else {

		json('Subscribed Email is sent.', 'alert');

	}

}

elseif ( 'cityedit' == $action ) {

	if ($id) {

		$category = Table::Fetch('cities', $id);

		if (!$category) json('No Data', 'alert');

		$zone = $category['zone'];

	} else {

		$zone = strval($_GET['zone']);

	}

	if ( !$zone ) json('Make sure your city/country', 'alert');

	$zone = get_zones($zone);



	if ($_GET['zone'] == 'city') {

		$groups = DB::LimitQuery('cities', array(

			'condition' => array( 'zone' => 'group', ),

			));

		$groupzone = Utility::OptionArray($groups, 'id', 'name');

		$catvalue= '<select name="czone" class="f-input">';

		foreach ($groupzone as $gzvalue) {

			$selected = ($category['czone']==$gzvalue) ? 'selected':'';

			$catvalue .='<option value='.$gzvalue.' '.$selected.'> '.$gzvalue. '';

		}

		$catvalue .='</select>';

	} else {

		$catvalue = '<input type="text" name="czone" value="' . $category['czone'] . '" class="f-input" />';

	}





	$html = render('manage_tsg_dialog_cityedit');

	json($html, 'dialog');

}

elseif ( 'cityremove' == $action ) {

	$category = Table::Fetch('cities', $id);

	if (!$category) json('No City/Country', 'alert');

	if ($category['zone'] == 'city') {

		$tcount = Table::Count('deals', array('city_id' => $id));

		if ($tcount ) json('This city/country has deals.', 'alert');

	}

	elseif ($category['zone'] == 'group') {

		$tcount = Table::Count('deals', array('group_id' => $id));

		if ($tcount ) json('This city/country has deals.', 'alert');

	}

	elseif ($category['zone'] == 'express') {

		$tcount = Table::Count('order', array('express_id' => $id));

		if ($tcount ) json('This city/country has active purchases.', 'alert');

	}

	elseif ($category['zone'] == 'public') {

		$tcount = Table::Count('topic', array('public_id' => $id));

		if ($tcount ) json('This city/country has active topics.', 'alert');

	}

	Table::Delete('cities', $id);

	option_category($category['zone']);

	Session::Set('notice', TEXT_EN_DELETE_OK_EN);

	json(null, 'refresh');

}

elseif ( 'categoryedit' == $action ) {

	if ($id) {

		$category = Table::Fetch('category', $id);

	}

	$html = render('manage_tsg_dialog_categoryedit');

	json($html, 'dialog');

}

elseif ( 'categoryremove' == $action ) {

	$category = Table::Fetch('category', $id);

	if (!$category) json('No Category', 'alert');

	if ($category['zone'] == 'city') {

		$tcount = Table::Count('deals', array('city_id' => $id));

		if ($tcount ) json('Deals in this category', 'alert');

	}

	elseif ($category['zone'] == 'group') {

		$tcount = Table::Count('deals', array('group_id' => $id));

		if ($tcount ) json('Deals in this category', 'alert');

	}

	elseif ($category['zone'] == 'express') {

		$tcount = Table::Count('order', array('express_id' => $id));

		if ($tcount ) json('Orders in this category', 'alert');

	}

	elseif ($category['zone'] == 'public') {

		$tcount = Table::Count('topic', array('public_id' => $id));

		if ($tcount ) json('Topics in this category', 'alert');

	}

	Table::Delete('category', $id);

	option_category($category['zone']);

	Session::Set('notice', TEXT_EN_DELETE_OK_EN);

	json(null, 'refresh');

}

else if ( 'dealscoupon' == $action ) {

	$deals = Table::Fetch('deals', $id);

	deals_state($deals);

	if (!$deals['close_time'] || $deals['now_number']<$deals['min_number'])

		json('Deal is not end or has not reach the minimum', 'alert');

	$orders = DB::LimitQuery('order', array(

				'condition' => array(

					'deals_id' => $id,

					'state' => 'pay',

					),

				));

	foreach($orders AS $order) {

		ZCoupon::Create($order);

	}

	json('Send coupon OK',  'alert');

}

else if ( 'agentremove' == $action ) {

	$agent = Table::Fetch('agent', $id);

	if ($agent) {

		Table::Delete('agent', $id);

		Session::Set('notice', "Agent {$id} deleted");

		json(null, 'refresh');

	}

}



else if ( 'changepartner' == $action ) {

	$strPartner = Table::Fetch('partner', $id);

	$strPartnerCommission	=	$strPartner["commission"];

	echo $strPartnerCommission;

}

