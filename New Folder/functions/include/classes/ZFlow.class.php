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

class ZFlow {

	static public function CreateFromOrder($order) {

		//if ( $order['credit'] == 0 ) return 0;



		//update user money;

		$user = Table::Fetch('user', $order['user_id']);

		Table::UpdateCache('user', $order['user_id'], array(

					'money' => array( "money - {$order['credit']}" ),

					));
					
					// Add the patch if the credit is zero
					
					if($order['credit']==0)
					{
					     	$money=$order['money'];
					}
					else if($order['credit']>0)
					{
					     	  $money=$order['credit'];
					}

        $dbname=$order['isinsta']==1?'insta':'deals';
        $deals=Table::Fetch($dbname,$order['deals_id'],'id');
		$u = array(

				'user_id' => $order['user_id'],

				'money' => $money,

				'direction' => 'expense',
                'partner_id' => $deals['partner_id'],
				'action' => 'buy',
                'commissionpercentage' => (100-$deals['commission']),
				'detail_id' => $order['deals_id'],
				'isinsta' => intval($order['isinsta']),

				'create_time' => time(),

				);

		$q = DB::Insert('flow', $u);

	}

	

	

	/* Added the Patch for for commision */

	static public function CreateFromOrderCommission($order,$strCommisionAmt='',$strCommisionby='',$strCommision='') {

		$strSuperadminID	=	'1';

		

		$user = Table::Fetch('user', $strSuperadminID);

		Table::UpdateCache('user', $strSuperadminID, array(

			'money' => array( "money + {$strCommisionAmt}" ),

		));
             if($strCommisionby=='admin'){
				 $strCommisionby='deal';
			 }else{
				  $strCommisionby='partner';
			 }
			 $dbname=$order['isinsta']==1?'insta':'deals';
        $deals=Table::Fetch($dbname,$order['deals_id'],'id');
		$u = array(

				'user_id' => $strSuperadminID,

				'money' => $strCommisionAmt,
				'partner_id' => $deals['partner_id'],
				'commissionby' => $strCommisionby,

				'direction' => 'commission',

				'action' => 'commission',

				'commissionpercentage' => $strCommision,

				'detail_id' => $order['deals_id'],
				
				'isinsta' => intval($order['isinsta']),

				'create_time' => time(),

				);
 
		$q = DB::Insert('flow', $u);
		
	}

	/* Added the Patch for for commision */



	static public function CreateFromCoupon($coupon) {

		if ( $coupon['credit'] <= 0 ) return 0;



		//update user money;

		$user = Table::Fetch('user', $coupon['user_id']);

		Table::UpdateCache('user', $coupon['user_id'], array(

					'money' => array( "money + {$coupon['credit']}" ),

					));



		$u = array(

				'user_id' => $coupon['user_id'],

				'money' => $coupon['credit'],

				'direction' => 'income',

				'action' => 'coupon',

				'detail_id' => $coupon['id'],

				'create_time' => time(),

				);

		return DB::Insert('flow', $u);

	}



	static public function CreateFromRefund($order) {

		global $login_user_id;

		if ( $order['state']!='pay' || $order['origin']<=0 ) return 0;



		//update user money;

		$user = Table::Fetch('user', $order['user_id']);

		Table::UpdateCache('user', $order['user_id'], array(

					'money' => array( "money + {$order['origin']}" ),

					));



		//update order

//Add the Patch for the user cash refend functionality

		Table::UpdateCache('order', $order['id'], array('state'=>'unpay','service'=>'cash'));



		$u = array(

				'user_id' => $order['user_id'],

				'admin_id' => $login_user_id,

				'money' => $order['origin'],

				'direction' => 'income',

				'action' => 'refund',

				'detail_id' => $order['deals_id'],

				'create_time' => time(),

				);

		return DB::Insert('flow', $u);

	}



	static public function CreateFromInvite($invite) {

		global $login_user_id;

		if ( $invite['pay']!='Y' && $INI['system']['invitecredit']<=0 ) return 0;



		//update user money;

		$user = Table::Fetch('user', $invite['user_id']);

		Table::UpdateCache('user', $invite['user_id'], array(

					'money' => array( "money + {$invite['credit']}" ),

					));



		$u = array(

				'user_id' => $invite['user_id'],

				'admin_id' => $login_user_id,

				'money' => $invite['credit'],

				'direction' => 'income',

				'action' => 'invite',

				'detail_id' => $invite['other_user_id'],

				'create_time' => $invite['buy_time'],

				);

		return DB::Insert('flow', $u);

	}



	static public function CreateFromStore($user_id=0, $money=0) {

		global $login_user_id;

		$money = intval($money);

		if ( $money == 0 || $user_id <= 0)  return;



		//update user money;

		$user = Table::Fetch('user', $user_id);

		Table::UpdateCache('user', $user_id, array(

					'money' => array( "money + {$money}" ),

					));



		/* switch store|withdraw */

		$direction = ($money>0) ? 'income' : 'expense';

		$action = ($money>0) ? 'store' : 'withdraw';

		$money = abs($money);

		/* end swtich */



		$u = array(

				'user_id' => $user_id,

				'admin_id' => $login_user_id,

				'money' => $money,

				'direction' => $direction,

				'action' => $action,

				'detail_id' => 0,

				'create_time' => time(),

				);

		return DB::Insert('flow', $u);

	}



	static public function CreateFromCharge($money,$user_id,$time,$service='Info Missing'){

		global $option_service;

		if (!$money || !$user_id || !$time) return 0;

		$pay_id = "charge-{$user_id}-{$time}";

		$pay = Table::Fetch('pay', $pay_id);

		if ( $pay ) return 0;

		$order_id = ZOrder::CreateFromCharge($money,$user_id,$time,$service);

		if (!$order_id) return 0;



		//insert pay record

		$pay = array(

			'id' => $pay_id,

			'order_id' => $order_id,

			'bank' => $option_service[$service],

			'currency' => $currency,

			'service' => $service,

			'create_time' => $time,

		);

		DB::Insert('pay', $pay);

		//end//



		//update user money;

		$user = Table::Fetch('user', $user_id);

		

		Table::UpdateCache('user', $user_id, array(

					'money' => $user['money'] + $money ,

					));



		$u = array(

				'user_id' => $user_id,

				'admin_id' => 0,

				'money' => $money,

				'direction' => 'income',

				'action' => 'charge',

				'detail_id' => $pay_id,

				'create_time' => $time,

				);

		return DB::Insert('flow', $u);

	}

}



