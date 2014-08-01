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

if (empty($userId)) {

	Utility::Redirect('index.php?view=login');

}



$id = abs(intval($_GET['id']));

if (!$id || !$deals = Table::FetchForce('deals', $id) ) {

	Utility::Redirect( $INI['system']['mlocation'] .'/index.php?view=recentDeal');

}



/* refer */

if (abs(intval($_GET['r']))) { 

	if($_rid) cookieset('_rid', abs(intval($_GET['r'])));

	Utility::Redirect( $INI['system']['mlocation'] .'/index.php?view=deal&id={$id}');// error: instead of single quot(') double quot is there

}

$city = Table::Fetch('cities', $deals['city_id']);

if(!$city) { $city = array('id' => 0, 'name' => 'All', ); }



$pagetitle = $deals['title'];



$discount_price = $deals['market_price'] - $deals['deals_price'];

$discount_rate = 100 - $deals['deals_price']/$deals['market_price']*100;



$left = array();

$now = time();

$diff_time = $left_time = $deals['end_time']-$now;



$left_day = floor($diff_time/86400);

$left_time = $left_time % 86400;

$left_hour = floor($left_time/3600);

$left_time = $left_time % 3600;

$left_minute = floor($left_time/60);

$left_time = $left_time % 60;



/* progress bar size */

$bar_size = ceil(190*($deals['now_number']/$deals['min_number']));

$bar_offset = ceil(5*($deals['now_number']/$deals['min_number']));



$partner = Table::Fetch('partner', $deals['partner_id']);



/* other dealss */

if ( abs(intval($INI['system']['sidedeals'])) ) {

	$oc = array( 

			'city_id' => $city['id'], 

			"id <> {$id}",

			"begin_time < {$now}",

			"end_time > {$now}",

			);

	$others = DB::LimitQuery('deals', array(

				'condition' => $oc,

				'order' => 'ORDER BY id DESC',

				'size' => abs(intval($INI['system']['sidedeals'])),

				));

}



$deals['state'] = deals_state($deals);



/* your order */

if ($login_user_id && 0==$deals['close_time']) {

	$order = DB::LimitQuery('order', array(

		'condition' => array(

			'deals_id' => $id,

			'user_id' => $login_user_id,

			'state' => 'unpay',

		),

		'one' => true,

	));

}

/* end order */

?>

<div id="content">

<div class="inner">

<?php if($deals['image']) { ?>

	<div class="thumb"><img src="<?php echo $domain; ?>image.php?img=/<?php echo $deals['image']; ?>" alt="" width="261" height="115" /></div>

	<div class="clear1"></div>

<?php } ?>

<div><strong>Deal: <?php echo $deals['title']; ?></strong></div>

<div class="m">

	Value : <?php echo $currency.number_format(moneyit($deals['market_price']),2); ?><br />

	Discount : <?php echo moneyit($discount_rate).'%'; ?><br />

	You Save : <?php echo number_format("{$currency}{$discount_price}",2); ?><br />

	<p><?php echo nl2br(strip_tags($deals['summary'])); ?></p>

</div>

<div class="m">

	Time left to buy: <strong>

	<?php if ($left_day > 0) { 

		echo "{$left_day} days {$left_hour} hours {$left_minute} minutes";

	 } else {

	 	echo "{$left_hour} hours {$left_minute} minutes {$left_time} seconds ";

	 }?>

	 </strong>

	 <br />

	 <strong><?php echo $deals['now_number']; ?></strong> bought and the deal has <strong><?php echo ($deals['min_number']-$deals['now_number']); ?></strong> to be on.

</div>

</div>

</div>