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

ob_start();

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();



$code = strval($_GET['code']);

$subscribe = Table::Fetch('subscribe', $code, 'secret');

if ($subscribe) {

	ZSubscribe::Unsubscribe($subscribe);

	Session::Set('notice', 'Unsubscribed, you will not get the daily deal information.');

}

//Add the patch When the user is click in unsubscribe option

Utility::Redirect( BASE_REF  . '/index.php');

