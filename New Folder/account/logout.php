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
 * @version		4.3.3
 * @since 		2011-11-16
 */
ob_start();

require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();



if(isset($_SESSION['user_id'])) {
	 $fblogouturl = $_SESSION['FBCONNECT_LOGOUT_URL'];

	ZLogin::ForceLogout();


	require_once(dirname(dirname(__FILE__)) . '/facebooklogout.php');
	
	

	if($fblogouturl!='') {
    	redirect($fblogouturl);
    	exit;
		redirect( BASE_REF . '/index.php');
	} else {
	   redirect( BASE_REF . '/index.php');
	}


}



redirect( BASE_REF . '/index.php');

?>