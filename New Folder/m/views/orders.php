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

$condition = array('user_id' => $login_user_id, 'deals_id > 0',);

$selector = strval($_GET['s']);

if ($selector == 'index') {
    
    } 

else if ($selector == 'unpay') {
    
    $condition['state'] = 'unpay';
    
    } 

else if ($selector == 'pay') {
    
    $condition['state'] = 'pay';
    
    } 

$count = Table::Count('deals', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$orders = DB::LimitQuery('order', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$deals_ids = Utility::GetColumn($orders, 'deals_id');

$dealss = Table::Fetch('deals', $deals_ids);

foreach($dealss AS $tid => $one) {
    
    deals_state($one);
    
     $dealss[$tid] = $one;
    
    } 

?>

<div id="content-1">

	<div class="inner-1">

	  <table width="" border="0" cellspacing="0" cellpadding="0" id="my-order">

		  <tr class="heading">

			<td width="714">Item</td>

			<td width="47">Qty</td>

			<td width="50" align="right" style="text-align:right; width:25;">Total</td>

			<td width="154" style="text-align:center;">Status</td>

	    </tr>

		  <?php foreach ($orders as $index => $one) {
    ?>

		  <tr <?php if ($index % 2 == 0) {
        ?> class="white" <?php } else {
        ?> class="gray" <?php } 
    ?> >

			<td><p><a class="deal-title" href="index.php?view=deal&id=<?php echo $one['deals_id'];
    ?>"><?php echo $dealss[$one['deals_id']]['title'];
    ?></a></p></td>

			<td><p><?php echo $one['quantity'];
    ?></p></td>

			<td align="right" width="50" style="text-align:right;width:25;"><?php echo $currency;
    ?><?php echo number_format(moneyit($one['origin']), 2);
    ?></td>

			<td style="text-align:center;"><p><?php if ($one['state'] == 'pay') {
        ?>Have paid<?php } elseif ($dealss[$one['deals_id']]['close_time'] > 0) {
        ?>Is expired<?php } else {
        echo 'Unpaid';
    } 
    ?></p></td>

		  </tr>

		  <?php } 
?>					  

		  

		</table>				

	</div>

</div>