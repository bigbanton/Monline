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

class ZCoupon

{

	static public function Consume($coupon) {

		if ( !$coupon['consume']=='N' ) return false;

		$u = array(

			'ip' => Utility::GetRemoteIp(),

			'consume_time' => time(),

			'consume' => 'Y',

		);

		Table::UpdateCache('coupon', $coupon['id'], $u);

		ZFlow::CreateFromCoupon($coupon);

		return true;

	}



	static public function CheckOrder($order) {

		$coupon_array = array('coupon', 'pickup');

		$dbname = ($order['isinsta']) ? 'insta' : 'deals';

		$deals = Table::FetchForce($dbname, $order['deals_id']);

		if ($order['isinsta']) {

			$deals['delivery']='coupon';

			$deals['now_number'] = $deals['min_number'] = 1;

		}



			$ocon = ($order['isinsta']) ? array(

							'deals_id' => $order['deals_id'],

							'state' => 'pay',

							'isinsta' => 1,

						) : array(

							'deals_id' => $order['deals_id'],

							'state' => 'pay',

						);



			if (!in_array($deals['delivery'], $coupon_array)) return;

			
 
			if($deals['now_number'] >= $deals['min_number']) {

			
			/** Add the patch is 02/01/2013  option price commission issue**/
			 
                $order_commission= DB::LimitQuery('order',array('condition'=>array('deals_id'=>$deals['id'],'state'=>'pay')));
				
				for($i=0;$i<=count($order_commission);$i++)
				{
				    $total_ammount=$total_ammount+$order_commission[$i]['price'];	
					
				}
				/** Added Patch for Commission on April 13 2011 **/

					$strDealPrice			=	$total_ammount;

					$strPartnerID			=	$deals["partner_id"];

					$strPartnerDetails  	=	Table::FetchForce('partner', $strPartnerID);
					
					 //If the partner commission is zero

					if(empty($strPartnerDetails['commission']))
					{
						$strPartnerDetails['commission']= (100-$deals['commission']);
					}

					if($deals['now_number']==$deals['min_number']) {

						$strPartnerCommission	=	$deals['min_number']*$strPartnerDetails["commission"];

						$strDealCommision		=	$deals["commission"];
						
						

					} else {

						$strPartnerCommission	=	$order["quantity"]*$strPartnerDetails["commission"];

						$strDealCommision		=	$deals["commission"];

					}

									

					if($strDealCommision > 0) {

						$strCommision		=	$strDealCommision;

						$strCommisionby		=	'admin';

						$strCommissionPer	=	$deals["commission"];

					} else {

						$strCommision		=	$strPartnerCommission;	

						$strCommisionby		=	'partner';

						$strCommissionPer	=	$strPartnerDetails["commission"];

					}	

					

					if($strCommision > 0) {

						$strCommisionAmt	=	($strDealPrice*$strCommision/100 );
                  
				/** Add the patch is 02/01/2013  option price commission issue**/
				
						ZFlow::CreateFromOrderCommission($order,$strCommisionAmt,$strCommisionby,$strCommissionPer);

					}

				/** Added Patch for Commission on April 13 2011 **/

				

				//init coupon create;

				if ($deals['now_number']-$deals['min_number']<5) {

					$orders = DB::LimitQuery('order', array(

						'condition' => $ocon,

					));

					foreach($orders AS $order) {

						self::Create($order);

					}

				}

				else{

					self::Create($order);

				}

			}

	}



	static public function Create($order) {

		$dbname = ($order['isinsta']) ? 'insta' : 'deals';

		$deal_type = ($order['isinsta']) ? 'Insta' : 'Regular';

		$deals = Table::Fetch($dbname, $order['deals_id']);

		$user = Table::Fetch('user', $order['user_id']);

		$partner = Table::Fetch('partner', $order['partner_id']);

		$ccon = ($order['isinsta']) ? array('order_id' => $order['id'], 'isinsta' => 1) : array('order_id' => $order['id']);

		$count = Table::Count('coupon', $ccon);



		while($count<$order['quantity']) {

			$id = Utility::GenSecret(8, Utility::CHAR_NUM);

			$cv = Table::Fetch('coupon', $id);

			if ($cv) continue;

			if ($order['isinsta']) $deals['credit']='0';
            if($deals['expire_time']==0){
				$deals['expire_time']=$deals['end_time'];
			}
			$coupon = array(

					'id' => $id,

					'user_id' => $order['user_id'],

					'partner_id' => $deals['partner_id'],

					'order_id' => $order['id'],

					'credit' => $deals['credit'],

					'deals_id' => $order['deals_id'],

					'secret' => Utility::GenSecret(6, Utility::CHAR_WORD),

					'expire_time' => $deals['expire_time'],

					'create_time' => time(),

					'gifted' => 'N',

					'giftbyid' => '',

					'isinsta' => $order['isinsta'],

					);

			DB::Insert('coupon', $coupon);

			if ($order['isgift']=='Yes') {

				_gift_coupon($deals, $coupon, $user, $order);

			} else {

				mail_coupon($deals, $coupon, $user);

				sms_coupon($coupon);

			}

			$count++;

		}

	}

	

	static public function MarkConsumed($cid) {

		$coupon = Table::FetchForce('coupon', $cid);

		if ( !$coupon['consume']=='N' ) return false;

		$u = array(

			'ip' => Utility::GetRemoteIp(),

			'consume_time' => time(),

			'consume' => 'Y',

			'agent' => ($_SESSION['partner_id']) ? 'PartnerID-'.$_SESSION['partner_id'] : 'AgentID-'.$_SESSION['agent_id'],

		);

		Table::UpdateCache('coupon', $coupon['id'], $u);

		ZFlow::CreateFromCoupon($coupon);

		return true;

	}



	static public function MarkExpired($cid) {

		$now = time();

		Table::UpdateCache('coupon', $cid, array(

			'ip' => Utility::GetRemoteIp(),

			'expire_time' => $now - 2465565, //Set it to past time

			'consume_time' => $now,			

		));

		

	}

}

