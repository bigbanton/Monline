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

 * @version		4.3.1

 * @since 		2011-06-14

 */

 

global $INI;

global $currency;

global $user_address;



need_login();



//error_reporting(E_ALL);

$now = time();


// Add the Patch for options.

if($order['option_price']>0){
	
     $deals['deals_price']=$order['option_price'];
	 	
}else if($order['option_price']==0){
	
	$deals['deals_price']= $order['price'];
}


$options=Table::Fetch('options',$order['option_id']);

$discount_price = $deals['market_price'] - $deals['deals_price'];



$discount_rate = round(100 - $deals['deals_price']/$deals['market_price']*100);



$name = $now.'_'.$user['id'].'_'.$order['id'].'_'.$deals['id'];



$admin_billing_address = Table::Fetch('user_address', '1', 'user_id');



if (!$user['realname'] || $user['realname']='') $user['realname']='Customer';



Invoice::init(array('company' => array('name' => $INI['system']['sitename'],

										'address' => "\n".$INI['system']['sitename']."\n",

										'email' => $INI['system']['cpemail']."\n\n",

										'logo' => dirname(__FILE__).'/themes/css/default/logo.gif'), 

					 'client'  => array('name' => $user['realname'],

										'email' => $user['email'],

										'address' => $user_address['address1']."\n".$user_address['address2']."\n".$user_address['city']."\n".$user_address['state'].$user_address['pincode']."\n".$user_address['country']),

					 'invoice' => array('name' => 'Invoice #'.$now.'_'.$user['id'].'_'.$order['id'].'_'.$deals['id'],

										'currency' => $INI['system']['currency'],

										'date' => date("M d, Y"),

										'due_date' => date("M d, Y"),

										'sendBCC' => abs(intval($INI['system']['bccinvoice']))),

					 'items'   => array('Daily Deal Purchase' => array('desc' => $deals['title'], 'amount' => $deals['deals_price'],'quantity'=>$order['quantity'],'option_desc'=>$options['title']),

										),

					 'savefile'   => array('filename' => $name.'.pdf','directory' => DIR_BACKEND.'/invoice/data', 'save'=>abs(intval($INI['system']['saveinvoice']))

										)									

										));

Invoice::apply_template('default_template');

if(isset($_GET['pdf'])){

Invoice::display('pdf', array('utf8' => true));

}elseif(isset($_GET['html'])){

Invoice::display('html', array('utf8' => true));

}

//Add the Patch for invoice user ammount and user ammount details.

if($order['card']<$deals['deals_price']*$order['quantity']){
	
	$remaining_balance=$user['money']-$order['credit'];
	
}else if($order['card']==$deals['deals_price']*$order['quantity']){
	 
	 $remaining_balance=$user['money'];
	 
}else{
	
$remaining_balance=$user['money']-$deals['deals_price']*$order['quantity'];

}
$invoice_message = "<div style='font-family:verdana,arial;font-size:11px;color:#111'>Dear ".$user['realname'].",<br/><br/>This is a payment receipt for Invoice ".$name." sent on ".date("M d, Y")."<br/><br/>Amount: ".$INI['system']['currency'].$deals['deals_price']*$order['quantity']."<br/>Total Paid: ".$INI['system']['currency'].$deals['deals_price']*$order['quantity']."<br/>Remaining Balance: ".$INI['system']['currency'].$remaining_balance."<br/>Status: Paid<br/><br/>You may review your order history at any time by logging in to your client area.<br/><br/>Note: This email will serve as an official receipt for this payment.<br/><br/><br/><br/>".$INI['system']['sitename']."</div>";



$arr = array('host' => '', 'port' => '', 'username' => '', 'password' => '');

Invoice::send_email('Invoice Payment Confirmation',$invoice_message,$arr);



$invoice=array();



$invoice['user_id']	= $user['id'];

$invoice['order_id']	= $order['id'];

$invoice['create_time']	= $now;

$invoice['deal_id']	= $deals['id'];

$invoice['name']	= $name;

$invoice['paid']	= 'Y';



	$table = new Table('invoice', $invoice);

	$details = array(

		'user_id', 'order_id', 'create_time',

		'deal_id', 'name', 'paid',

	);



	$table->insert($details);



?>