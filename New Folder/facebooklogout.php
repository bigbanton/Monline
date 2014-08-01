<?php
require_once ('facebook.php');

//$fb = new Facebook(APIKEY, SECRET);

$fb = new FacebookB(array(
  	'appId' => $INI['system']['fbappid'],
  	'secret' => SECRET,
  	'cookie' => false,
	));

$uid = $fb->getUser();

if($uid) {
	
	/*$time = time()+(5 * 60);
	$_SESSION['facebooklogout']=$time;
	unset($_SESSION['facebooklogout']);
	setcookie (APIKEY.'_user', '', time() - 3600);*/
	$fb->destroySession();
	header($_SERVER['HTTP_REFERER']);
}
?>