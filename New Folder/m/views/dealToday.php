<?php

/**
 * //License information must not be removed.
 * 
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @Architecture ### Secured  ###
 * @Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @License EULA License http://www.gripsell.com
 * @Author $Author: gripsell $
 * @Version $Version: 5.3.3 $
 * @Last Revision $Date: 2013-21-05 00:00:00 +0530 (Tue, 21 May 2013) $
 */

if (empty($userId)) {
    
    // no login required
    // Utility::Redirect('index.php?view=login');
    } 

$request_uri = 'index';

$deals = current_deals($city['id']);

$_GET['id'] = abs(intval($deals['id']));

$id = abs(intval($_GET['id']));

if (!$id || !$deals = Table::FetchForce('deals', $id)) {
    
    Utility::Redirect(WEB_ROOT . '/m/index.php?view=recentDeal');
    
    } 

/**
 * refer
 */

if (abs(intval($_GET['r']))) {
    
    if ($_rid) cookieset('_rid', abs(intval($_GET['r'])));
    
     Utility::Redirect(WEB_ROOT . "/m/index.php?view=deal&id={$id}");
    
    } 

$city = Table::Fetch('cities', $deals['city_id']);

if (!$city) {
    $city = array('id' => 0, 'name' => 'All',);
} 

$pagetitle = $deals['title'];

$discount_price = $deals['market_price'] - $deals['deals_price'];

$discount_rate = 100 - $deals['deals_price'] / $deals['market_price'] * 100;

$left = array();

$now = time();

$diff_time = $left_time = $deals['end_time'] - $now;

$left_day = floor($diff_time / 86400);

$left_time = $left_time % 86400;

$left_hour = floor($left_time / 3600);

$left_time = $left_time % 3600;

$left_minute = floor($left_time / 60);

$left_time = $left_time % 60;

/**
 * progress bar size
 */

$bar_size = ceil(190 * ($deals['now_number'] / $deals['min_number']));

$bar_offset = ceil(5 * ($deals['now_number'] / $deals['min_number']));

$partner = Table::Fetch('partner', $deals['partner_id']);

/**
 * other dealss
 */

if (abs(intval($INI['system']['sidedeals']))) {
    
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

/**
 * your order
 */

if ($login_user_id && 0 == $deals['close_time']) {
    
    $order = DB::LimitQuery('order', array(
            
            'condition' => array(
                
                'deals_id' => $id,
                
                 'user_id' => $login_user_id,
                
                 'state' => 'unpay',
                
                ),
            
             'one' => true,
            
            ));
    
    } 

/**
 * end order
 */

?>

<div id="content">

	<div class="inner"> 

		<div class="thumb"><img src="<?php echo $domain;
?>image.php?img=/<?php echo $deals['image'];
?>" alt="" width="261" height="115" /></div>

		<div class="clear"></div>

		

		<p><strong>Today's Deal</strong></p>

		<p><span class="price-1"><?php echo $deals['title'];
?></span></p>

		

		<div class="box-1">

			<p>Value : <?php echo $currency . number_format(moneyit($deals['market_price']), 2);
?> &nbsp; &nbsp; &nbsp;Discount : <?php echo moneyit($discount_rate) . '%';
?> &nbsp; &nbsp; &nbsp;     You Save : <?php echo $currency . number_format(moneyit($discount_price), 2);
?></p>

		</div>

		<div class="clear"></div>

		

		<p>Time left to buy: <span class="red"><?php if ($left_day > 0) {
    
    echo "{$left_day} days {$left_hour} hours {$left_minute} minutes";
    
     } else {
    
    echo "{$left_hour} hours {$left_minute} minutes {$left_time} seconds ";
    
     } 
?></span></p>

		<p><span class="red"><?php echo $deals['now_number'];
?></span> bought and the deal has <span class="red"><?php echo ($deals['min_number'] - $deals['now_number']);
?></span> to be on. </p>

	</div>

</div>