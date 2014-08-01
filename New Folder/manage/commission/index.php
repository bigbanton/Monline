<?php
/**
 * //License information must not be removed.
 * PHP version 5.2x
 *
 * @category	### Gripsell ###
 * @package		### Advanced ###
 * @arch		### Secured  ###
 * @author 		Development Team, Gripsell Tech
 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @license		http://www.gripsell.com Clone Portal
 * @version		4.2.9
 * @since 		2011-02-09
 */  
	ob_start();
	require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
	$ob_content = ob_get_clean();
	
	need_manager();
	$module = 'orders';
	$condition = array("action" =>'commission','commissionby' => 'deal'); 
	$count = Table::Count('flow', $condition);
	
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	
	$aDeals = DB::LimitQuery('flow', array(
		'condition' => $condition,
		'order' => "Group by detail_id,isinsta ORDER BY id DESC",
		'size' => $pagesize,
		'offset' => $offset,
	));
 $total_price=0;
	$strTotalAmt=0;
	for($i=0; $i<count($aDeals); $i++){ 
		$dbname=$aDeals[$i]['isinsta']==1?'insta':'deals';
		
		$aTemp = DB::LimitQuery($dbname, array(
			'condition' => "id = '".$aDeals[$i]['detail_id']."'",
		));
		
		$aorder = DB::LimitQuery('order', array(
			'condition' =>array('deals_id'=>$aDeals[$i]['detail_id'],'state'=>'pay'),
		));
		$total_price=0;
		//print_r($aorder);
		for($j=0;$j<count($aorder);$j++)
		{
			$total_price=$total_price+$aorder[$j]['price'];
		}
		
		
		$aDeals[$i]['deal'] = $aTemp[0];
		
		$aDeals[$i]['deal']['partnercommission']	=	$aDeals[$i]["commissionpercentage"];
	
	
		$strEarningAmt				=	($total_price*$aDeals[$i]['deal']['commission']/100);

		$aDeals[$i]['deal']['money']	=	number_format($strEarningAmt,2);
		
		$strTotalAmt=$strEarningAmt+$strTotalAmt;
	}
	
	
	//echo $strEarningAmt;exit;
$strTotalAmt	=	number_format($strTotalAmt,2);

//print_r($aDeals);exit;

include template('manage_commission_index');