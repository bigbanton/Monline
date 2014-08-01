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

	// no login required

	//Utility::Redirect('index.php?view=login');

}



$daytime = time();



$condition = array( 

		'city_id' => array(0, abs(intval($city['id']))),

		"begin_time <  {$daytime}",

		"end_time > {$daytime}",

		"stage = 'approved'",

		

		);



$count = Table::Count('deals', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$dealss = DB::LimitQuery('deals', array(

	'condition' => $condition,

	'order' => 'ORDER BY begin_time DESC, id DESC',

	'size' => $pagesize,

	'offset' => $offset,

));

foreach($dealss AS $id=>$one){

	deals_state($one);

	if ($one['state']=='none') $one['picclass'] = 'isopen';

	if ($one['state']=='soldout') $one['picclass'] = 'soldout';

	$dealss[$id] = $one;

}

//echo '<pre>';

//print_r($dealss);

//echo '</pre>';

//echo 'Recent Deal: Under Construction'

?>



			

			<div id="content">

				<div class="inner-1">

				<?php foreach($dealss AS $id=>$one){ ?>

					<div class="sets">

						<p class="bold"><?php echo date('jS M Y', $one['begin_time']); ?></p>
                        
                         

						<p><span class="price-1"><a href="index.php?view=deal&id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>"><?php echo $one['title']; ?></a></span></p>

					   <div class="thumb"><img src="<?php echo $domain; ?>image.php?img=/<?php echo $one['image']; ?>" alt="" width="261" height="115" /></div>

						<div class="box-2">

							<p><span class="spacer"><?php echo $one['now_number']; ?> Buyers</span>	<span class="spacer">Value : <?php echo $currency; ?><?php echo number_format(moneyit($one['market_price']),2); ?></span> <span class="spacer">Discount : <?php echo moneyit(100 - (100*$one['deals_price']/$one['market_price'])); ?>%</span>  <span class="spacer">Price: <?php echo $currency; ?><?php echo number_format(moneyit($one['deals_price']),2); ?></span> You Save : <?php echo $currency; ?><?php echo number_format(moneyit($one['market_price']-$one['deals_price']),2); ?></p>

						</div>

						<div class="clear1"></div>

					</div>

				<?php } ?>

				

				</div>

</div>

<div class="clear"></div>

<div><?php echo $pagestring; ?></div>