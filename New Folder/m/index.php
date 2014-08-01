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

ob_start();

session_start();

require_once('config.php');

require_once('init.php');

if (!isset($userid) || !$userid) {
    
    $userId = Session::Get('user_id');
    
     Session::Set('user_id_mobile', $userId);
    
    } 

if (!isset($userid) || !$userid) {
    
    $userId = Session::Get('user_id_mobile');
    
    } 

if ($INI['system']['mservice'] == 0) {
    Utility::Redirect(BASE_REF . '/index.php');
    } 

$page = 'home';

if (isset($_GET['view']) && trim($_GET['view'])) {
    
    $page = $_GET['view'];
    
    } 

// if(!$_SESSION['usr_id'] && $page !='login'){
 // header('location:index.php');
// }

// header("Content-type: text/vnd.wap.wml");
/**
 * echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
 * 
 * 
 * 
 * echo '<?xml version="1.0" encoding="UTF-8"?>';
 */

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8" />

<meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1 user-scalable=no,width = 320" />

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

<meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="apple-mobile-web-app-status-bar-style" content="default" />

<link rel="apple-touch-icon" href="" />

<title><?php echo $INI['system']['abbreviation'];
?>::Mobile</title>

<link href="mobile.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="wrapper">

<div id="top">

			<div style="float:left;width:128px;"> 

				<a href="index.php">

					<img src="images/mobile-logo.png" border="0">

				</a>	

			</div>

			<div class="links">

				<?php if ($userId) {
    ?>

				        <form action="index.php?view=login&act=logout" method="POST">          

						  <input type="submit" name="myaccount" value="My Group Buy" class="buttons" />		  

				          <input type="submit" name="sign_out" value="Exit" class="buttons" />                   

				        </form>

				

				 <?php } else {
    ?>

				         <form action="index.php?view=login" method="get">

				          <input type="hidden" name="view" value="login" />

						  <input type="submit" name="myaccount" value="My Account" class="buttons" />		

				          <input type="submit" name="commit" value="Login" class="buttons" />                    

				        </form>

				<?php } 
?>    

			</div>

			<div class="clear"></div>	

			<div id="menu">

				<ul>

					<li <?php if ($page == 'dealToday') {
    ?> class="active" <?php } 
?>><a href="index.php?view=dealToday">Todays Deal</a></li>

					<li <?php if ($page == 'recentDeal') {
    ?> class="active" <?php } 
?>><a href="index.php?view=recentDeal">Recent Deals</a></li>

					<li <?php if ($page == 'claimCoupon') {
    ?> class="active" <?php } 
?> ><a href="index.php?view=claimCoupon">Claim Coupon</a></li>

				</ul>

			</div>

		</div>

<div id="content-area">

<?php if ($page != 'home' && $page != 'claimCoupon') {
    ?>

<form action="index.php?view=home" method="post">

<div class="heading-section">

				<div class="head-in">

					<p>Cities</p>

					<div class="country">	

						

							

								<select name="cities" class="country-drop">

									<?php echo Utility::Option(Utility::OptionArray($hotcities, 'id', 'name'), $city['id']);
    ?>

								</select>

								

							

						

					</div>

					<p>

						<input type="submit" name="update-submit" value="Change" class="buttons"/>

					</p>

				</div>

			</div>

</form>

<?php } 
?>

  <?php if ($varMsg) {
    ?>

  <div class="y"><?php echo $varMsg;
    ?></div>

  <?php } else {
    ?>

	<div>

    <?php require_once("views/{$page}.php");
    ?>

	</div>

	    

	<div class="heading-section">

				<div class="view-type">

					<p>

						<?php if ($page != 'home' && $page != 'dealToday') {
        ?>

							<input type="button" value="Back" class="buttons" onclick="history.go(-1)" />

						<?php } 
    ?>

					</p>

				</div>

			</div>

<?php } 
?>

</div>

</div>

</body>

</html>

<?php ob_flush();
?>