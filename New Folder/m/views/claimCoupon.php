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
    
    Utility::Redirect('index.php?view=login');
    
    } 

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
$v = '';

$action = strval($_POST['action']);

$cid = strval($_POST['id']);

$sec = strval($_POST['secret']);

if (isset($_POST['consume'])) {
    
    $action = 'consume';
    
    } 

if (isset($_POST['query'])) {
    
    $action = 'query';
    
    } 

if ($action == 'dialog') {
    
    $html = render('ajax_dialog_coupon');
    
     json($html, 'dialog');
    
    } 

else if ($action == 'query') {
    
    $coupon = Table::FetchForce('coupon', $cid);
    
     $partner = Table::Fetch('partner', $coupon['partner_id']);
    
     $deals = Table::Fetch('deals', $coupon['deals_id']);
    
     $e = date('Y-m-d', $deals['expire_time']);
    
    
    
     if (!$coupon) {
        
        $v[] = "#{$cid}&nbsp;Invalid";
        
         } else if ($coupon['consume'] == 'Y') {
        
        $v[] = $INI['system']['couponname'] . 'Invalid';
        
         $v[] = 'Used on: ' . date('Y-m-d H:i:s', $coupon['consume_time']);
        
         } else if ($coupon['expire_time'] < strtotime(date('Y-m-d'))) {
        
        $v[] = "#{$cid}&nbsp; is expired";
        
         $v[] = 'Valid till: ' . date('Y-m-d', $coupon['consume_time']);
        
         } else {
        
        $v[] = "#{$cid}&nbsp;valid";
        
         $v[] = "{$deals['title']}";
        
         $v[] = "Valid till &nbsp;{$e}";
        
         } 
    
    $v = join('<br/>', $v);
    
     // echo '<pre>';
    // print_r($v);
    // echo '</pre>';
    
/**
     * $d = array(
     * 
     * 'html' => $v,
     * 
     * 'id' => 'coupon-dialog-display-id',
     * 
     * );
     * 
     * json($d, 'updater');
     */
    
    } 

else if ($action == 'consume') {
    
    $coupon = Table::FetchForce('coupon', $cid);
    
     $partner = Table::Fetch('partner', $coupon['partner_id']);
    
     $deals = Table::Fetch('deals', $coupon['deals_id']);
    
    
    
     if (!$coupon) {
        
        $v[] = "#{$cid}&nbsp;Invalid";
        
         $v[] = 'Failed';
        
         } 
    
    else if ($coupon['secret'] != $sec) {
        
        $v[] = $INI['system']['couponname'] . 'Invalid Code';
        
         $v[] = 'Failed';
        
         } else if ($coupon['expire_time'] < strtotime(date('Y-m-d'))) {
        
        $v[] = "#{$cid}&nbsp;is Expired";
        
         $v[] = 'Valid Till: ' . date('Y-m-d', $coupon['consume_time']);
        
         $v[] = 'Failed';
        
         } else if ($coupon['consume'] == 'Y') {
        
        $v[] = "#{$cid}&nbsp;is Used";
        
         $v[] = 'Buy at: ' . date('Y-m-d H:i:s', $coupon['consume_time']);
        
         $v[] = 'Failed';
        
         } else {
        
        ZCoupon::Consume($coupon);
        
         // credit to user'money'
        $tip = ($coupon['credit'] > 0) ? " Get {$coupon['credit']} dollars rebate" : '';
        
         $v[] = $INI['system']['couponname'] . 'Valid';
        
         $v[] = 'Buy at: ' . date('Y-m-d H:i:s', time());
        
         $v[] = 'Buy successfully' . $tip;
        
         } 
    
    $v = join('&nbsp;', $v);
    
     // echo '<pre>';
    // print_r($v);
    // echo '</pre>';
    
/**
     * $d = array(
     * 
     * 'html' => $v,
     * 
     * 'id' => 'coupon-dialog-display-id',
     * 
     * );
     * 
     * json($d, 'updater');
     */
    
    } 

?>

<?php if ($v) {
    ?>

	<div class="y"><?php echo $v;
    ?></div>

<?php } 
?>

<div class="heading-section">

	<div class="head-in">

		<p>Verify and Claim Coupon</p>

	</div>

</div>

<div id="content">

				<div class="inner">

					<form action="index.php?view=claimCoupon" method="post">

						<div class="coupon-left"><p>Coupon Serial</p></div>

						<div class="coupon-right">

							<input class="i" id="session[id]" name="id" type="text" value="" />

						</div>

						<div class="clear"></div>

						

						<div class="coupon-left"><p>Coupon Password</p></div>

						<div class="coupon-right">

							<input class="i" id="session[secret]" name="secret" type="text" value="" />

						</div>

						<div class="clear"></div>

						

						<div class="coupon-btns">

							<input class="buttons" name="query" type="submit" value="Inquire" />

							<input class="buttons" name="consume" type="submit" value="Claim" />

						</div>

					</form>

				</div>

</div>