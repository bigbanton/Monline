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

?>

<div id="content">

<div class="inner">

	<a class="myacc" href="index.php?view=orders" title="View Orders">My Order</a><br />

	<a class="myacc" href="index.php?view=coupons" title="View Orders">My Coupon</a><br />

	<a class="myacc" href="index.php?view=balance" title="View Orders">Balance</a>

</div>

</div>