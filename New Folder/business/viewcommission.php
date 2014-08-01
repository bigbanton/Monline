<?php

	/**

	 * //License information must not be removed.

	 * PHP version 5.3x

	 *

	 * @category	### Gripsell ###

	 * @package		### Advanced ###

	 * @arch		### Secured  ###

	 * @author 		Development Team, Gripsell Technologies Pvt Ltd

	 * @copyright 	Copyright (c) 2012 {Licensed by Gripsell Technologies Pvt Ltd. All Rights Reserved}

	 * @license		http://www.gripsell.com

	 * @version		5.0

	 * @since 		2011-11-16

	 */

 

	ob_start();

	require_once(dirname(dirname(__FILE__)) . '/app.php');

	$ob_content = ob_get_clean();

	need_partner();

	$partner_id = abs(intval($_SESSION['partner_id']));

	$login_partner = Table::Fetch('partner', $partner_id);

	

	$condition = array(

		'partner_id' => $partner_id,

	);
/*
	$count = Table::Count('deals', $condition);

	list($pagesize, $offset, $pagestring) = pagestring($count, 10);

	

	$deals = DB::LimitQuery('deals', array(

		'condition' => $condition,

		'order' => 'ORDER BY id DESC',

		'size' => $pagesize,

		'offset' => $offset,

	));

	$strTotalAmt=0;

	for($i=0; $i<count($deals); $i++){

		$strWhere	= "detail_id = '".$deals[$i]['id']."' and commissionpercentage!=0";

		$aTemp = DB::LimitQuery('flow', array(

			'condition' => $strWhere,

			'select' =>'id,commissionby,sum(money) as commissionamt,detail_id,create_time,commissionpercentage',

		));

		$deals[$i]['commissionby']		=	$aTemp[0]["commissionby"];

		$deals[$i]['commissionamt']		=	$aTemp[0]["commissionamt"];

		$deals[$i]['partnercommission']	=	$aTemp[0]["commissionpercentage"];



		$strEarningAmt				=	(($deals[$i]['deals_price']*$deals[$i]['commission'])/100)*$deals[$i]['now_number'];

		$deals[$i]['strEarings']	=	number_format($strEarningAmt,2);
		
		$strTotalAmt=$strEarningAmt+$strTotalAmt;
	}
$strTotalAmt	=	number_format($strTotalAmt,2);
	*/
	//patch added on 28 july 2012
	
$condition = array("action" =>'buy','commissionby' => 'deal','partner_id' => $partner_id,); 
//$condition = "action='commission' commissionby='deal' Group by deal ORDER BY id DESC";
	$count = Table::Count('flow', $condition);
	
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	
	$aDeals = DB::LimitQuery('flow', array(
		'condition' => $condition,
		'order' => "Group by detail_id,isinsta ORDER BY id DESC",
		'size' => $pagesize,
		'offset' => $offset,
	));

	$strTotalAmt=0;
	for($i=0; $i<count($aDeals); $i++){ 
		$dbname=$aDeals[$i]['isinsta']==1?'insta':'deals';
		
		$aTemp = DB::LimitQuery($dbname, array(
			'condition' => "id = '".$aDeals[$i]['detail_id']."'",
		));
		
		$aDeals[$i]['deal'] = $aTemp[0];
		
		$aDeals[$i]['deal']['partnercommission']	=	$aDeals[$i]["commissionpercentage"];
	
	
		//$strEarningAmt				=	(($aDeals[$i]['money']*$aDeals[$i]['commissionpercentage'])/100)*$aDeals[$i]['deal']['now_number'];
		$strEarningAmt				=	(($aDeals[$i]['deal']['deals_price']*$aDeals[$i]['deal']['now_number'])*$aDeals[$i]['commissionpercentage'])/100;

		$aDeals[$i]['deal']['money']	=	number_format($strEarningAmt,2);
		
		$strTotalAmt=$strEarningAmt+$strTotalAmt;
	}
$strTotalAmt	=	number_format($strTotalAmt,2);


	$city_ids = Utility::GetColumn($deals, 'city_id');

	$cities = Table::Fetch('cities', $city_ids);

	

	

	include template('viewcommission');

