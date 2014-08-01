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

require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();



need_login();



$condition = array( 

		'user_id' => $login_user_id, 

		'credit > 0',

		'pay' => 'Y',

		);

$count = Table::Count('invite', $condition);

$money = Table::Count('invite', $condition, 'credit');

list($pagesize, $offset, $pagestring) = pagestring($count, 20);



$invites = DB::LimitQuery('invite', array(

			'condition' => $condition,

			'order' => 'ORDER BY buy_time DESC',

			'size' => $pagesize,

			'offset' => $offset,

			));



$user_ids = Utility::GetColumn($invites, 'other_user_id');

$deals_ids = Utility::GetColumn($invites, 'deals_id');

//Add the patch for the user is refer to the friend functionality

$users = Table::Fetch('user', $user_ids);

$deals = Table::Fetch('deals', $deals_ids);



include template('user_refer');

