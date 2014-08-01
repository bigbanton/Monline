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

class Zdeals

{

	static public function Deletedeals($id) {

		$orders = Table::Fetch('order', array($id), 'deals_id');

		foreach( $orders AS $one ) {

			if ($one['state']=='pay') return false;

			if ($one['card_id']) {

				Table::UpdateCache('card', $one['card_id'], array(

					'deals_id' => 0,

					'order_id' => 0,

					'consume' => 'N',

				));

			}

			Table::Delete('order', $one['id']);

		}



		# ACTIVITY LOG

		global $login_user_id;

		ZLog::Log($login_user_id, 'Deal Deleted','Alert >> Deal Deleted, Deal Type:Regular, Deal ID:'.$id);

		# ACTIVITY LOG

				

		return Table::Delete('deals', $id);

	}

	

	static public function DeleteInsta($id) {

		//$orders = Table::Fetch('order', array($id), 'deals_id');
		
		 $orders = DB::LimitQuery('order', array('condition'=>array(
                                                              'deals_id'=>  $id,
                                                              'isinsta'=>1,),));

		foreach( $orders AS $one ) {

			if ($one['state']=='pay') return false;

			if ($one['isinsta']==1 && $one['card_id']) {

				Table::UpdateCache('card', $one['card_id'], array(

					'deals_id' => 0,

					'order_id' => 0,

					'consume' => 'N',

				));

			}

			if ($one['isinsta']==1) Table::Delete('order', $one['id']);

		}

		

		$deal_detail = Table::Fetch('insta_details', array($id), 'deal_id');

		foreach( $deal_detail AS $one ) {

			Table::Delete('insta_details', $one['id']);

		}



		# ACTIVITY LOG

		global $login_user_id;

		ZLog::Log($login_user_id, 'Deal Deleted','Deal Type:Insta, Deal ID:'.$id);

		# ACTIVITY LOG



		return Table::Delete('insta', $id);

	}



	static public function BuyOne($order) {

		$dbname = ($order['isinsta']) ? 'insta' : 'deals';

		$deal_type = ($order['isinsta']) ? 'Insta' : 'Regular';

		$order = Table::FetchForce('order', $order['id']);

		$deals = Table::FetchForce($dbname, $order['deals_id']);

		$user = Table::Fetch('user', $order['user_id']);
       if($order['option_price']>0){
       $deals['deals_price']=$order['option_price'];
      }
		

			$plus = $deals['conduser']=='Y' ? $order['quantity']: 1;

			$deals['now_number'] += $plus;

		

			if (!$order['isinsta']) {

				if ( $deals['max_number']>0 

						&& $deals['now_number'] >= $deals['max_number'] ) {

					$deals['close_time'] = time();

				}

				Table::UpdateCache('deals', $deals['id'], array(

					'close_time' => $deals['close_time'],

					'now_number' => array( "`now_number` + {$plus}", ),

				));

			} else {

				Table::UpdateCache('insta', $deals['id'], array(

					'now_number' => array( "`now_number` + {$plus}", ),

				));



			}

			

		mail_purchase($deals,$user,$order);



		/* cash flow */

		ZFlow::CreateFromOrder($order);

		/* order : send coupon ? */

		ZCoupon::CheckOrder($order);

		/* order : invite buy */

		ZInvite::CheckInvite($order);

		

		

		global $INI;

		if (abs(intval($INI['system']['paidinvoice']))) require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/invoice.php');



		# ACTIVITY LOG

		ZLog::Log($user['id'], 'Deal Purchased', 'Deal Type:' . $deal_type . ', Deal ID:'.$order['deals_id']);

		# ACTIVITY LOG

	}

}



