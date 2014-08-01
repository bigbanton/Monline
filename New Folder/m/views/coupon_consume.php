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

$daytime = strtotime(date('Y-m-d'));

$condition = array(
    
    'user_id' => $login_user_id,
    
     'consume' => 'Y',
    
    );

$count = Table::Count('coupon', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$coupons = DB::LimitQuery('coupon', array(
        
        'condition' => $condition,
        
         'coupon' => 'ORDER BY create_time DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$deals_ids = Utility::GetColumn($coupons, 'deals_id');

$dealss = Table::Fetch('deals', $deals_ids);

?>

<div id="content-1">

	<div class="inner-1">

	<div class="heading-section">	

		<div class="head-in">

			<p>My Coupons::Used</p>

		</div>

	</div>

<div>

Category : <a href="index.php?view=coupons">not used</a> | 

<a href="index.php?view=coupon_consume">used</a> | 

<a href="index.php?view=coupon_expire">expired</a>

</div>

	<?php if ($selector == 'index' && !$coupons) {
    ?>

	<div class="notice">There is no usable <?php echo $INI['system']['couponname'];
    ?></div>

	<?php } 
?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="my-order">

		<tr class="heading">

			<td width="40%">Item</td>

			<td width="20%"> Co. No.</td>			

			<td width="30%"> Used date</td>			

		</tr>

		<?php if ($coupons) {
    foreach ($coupons as $index => $one) {
        ?>

		<tr <?php if ($index % 2 == 0) {
            ?> class="white" <?php } else {
            ?> class="gray" <?php } 
        ?> >

			<td valign="top"><p><a class="deal-title" href="index.php?view=deal&id=<?php echo $one['deals_id'];
        ?>"><?php echo $dealss[$one['deals_id']]['title'];
        ?></a></p></td>

			<td valign="top"><p><?php echo $one['id'];
        ?></p></td>			

			<td valign="top"><p><?php echo date('m-d-Y', $one['consume_time']);
        ?></p></td>

		</tr>	

		<?php } 
} else {
    ?>

			<tr height="60">

				<td valign="middle" colspan="3">

					<div class="indexerror">

						<p>Sorry no coupons found.</p>

					</div>

				</td>

			</tr>

		<?php } 
?>

		<?php if ($coupons) {
    ?>

			<tr><td colspan="5"><br/><?php if ($coupons) {
        echo $pagestring;
    } 
    ?></td></tr>

		<?php } 
?>

    </table>

</div>

</div>