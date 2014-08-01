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

$condition = array('user_id' => $login_user['id'],);

$count = Table::Count('flow', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$flows = DB::LimitQuery('flow', array(
        
        'condition' => $condition,
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
         'order' => 'ORDER BY id DESC',
        
        ));

$detail_ids = Utility::GetColumn($flows, 'detail_id');

$dealss = Table::Fetch('deals', $detail_ids);

$users = Table::Fetch('user', $detail_ids);

$coupons = Table::Fetch('coupon', $detail_ids);

?>

<div id="content-1">

	<div class="inner-1">

<div class="heading-section">	

	<div class="head-in">

		<p>Balance</p>

	</div>

</div>

<div id="content">

<div class="inner">

	<p>Your current account balance is: <strong><?php echo '$' . number_format(moneyit($login_user['money']), 2);
?></strong></p>

	<!--<table id="order-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">

		<tr>

			<th width="120">Time</th>

			<th width="auto">Detail</th>

			<th width="50">Pay and Receive</th>

			<th width="70">Total Amount</th>

		</tr>

		<?php foreach ($flows as $index => $one) {
    ?>		

		<tr ${$index%2?'':'class="alt"'}>

			<td style="text-align:left;">${date('Y-m-d H:i', $one['create_time'])}</td>

			<td><?php echo $option_flow[$one['action']];
    ?>&nbsp;-&nbsp;<?php if ($one['action'] == 'coupon') {
        echo $INI['system']['couponname'];
        ?> rebate <?php } elseif ($one['action'] == 'invite') {
        ?> Friends: <?php echo $users[$one['detail_id']]['username'];
    } elseif ($one['action'] == 'buy') {
        ?><a href="index.php?view=deals&id=<?php echo $one['detail_id'];
        ?>"><?php echo $dealss[$one['detail_id']]['product'];
        ?></a><?php } elseif ($one['action'] == 'refund') {
        ?><a href="index.php?view=deals&id=<?php echo $one['detail_id'];
        ?>"><?php echo $dealss[$one['detail_id']]['product'];
        ?></a><?php } elseif ($one['action'] == 'charge') {
        ?>Online topup<?php } elseif ($one['action'] == 'withdraw') {
        ?>User withdraw <?php } elseif ($one['action'] == 'store') {
        ?>Offline topup><?php } 
    ?></td>

			<td class="<?php echo $one['direction'];
    ?>"><?php echo $one['direction'] == 'income'?'Income':'Outcome';
    ?></td>

			<td><?php echo moneyit($one['money']);
    ?></td>

		</tr>

		<?php } 
?>

		<tr><td colspan="4"><br/><?php echo $pagestring;
?></td></tr>

    </table>-->

</div>

</div>

</div>