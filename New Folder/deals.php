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



 * @version		4.3.0



 * @since 		2011-04-26



 */



ob_start();



require_once(dirname(__FILE__) . '/app.php');



$ob_content = ob_get_clean();





$id = abs(intval($_GET['id']));



/** Added the patch for Subscription Box **/



if(($_GET['action']=='subscribe') || (!$login_user && !cookieget('subs') && !isset($_GET['subs']) && abs(intval($INI['display']['subpop'])))){

	die(include_once('steps.php'));



} else {



	if (isset($_GET['subs'])) {

		cookieset("subs","1");

		Utility::Redirect('index.php');

	}



if ($id) {



	$oc = array( 



			"(city_id = '0' OR find_in_set({$city['id']},city_id))", 



			'id' => $id,



			"begin_time < {$now}",



			"end_time > {$now}",



			'stage' => array('1-featured','approved'),



			);



} else {



	$oc = array( 



			"(city_id = '0' OR find_in_set({$city['id']},city_id))", 



			"begin_time < {$now}",



			"end_time > {$now}",



			'stage' => array('1-featured','approved'),

			

			);



}



	$deals = DB::LimitQuery('deals', array(



				'condition' => $oc,



				'size' => 1,

				

				'order' => 'ORDER BY stage',





				));



if ($deals) $id = $deals[0]['id'];



if (!$id || !$deals = Table::FetchForce('deals', $id) ) {



	Utility::Redirect( BASE_REF . '/zone.php');



}



$deal_locations = DB::LimitQuery('deal_locations', array('condition'=>array('deal_id' => $id,), 'order'=>'ORDER BY id ASC'));



if (!$deal_locations_count = count($deal_locations)) $deal_locations_count=1;



/* refer */



if (abs(intval($_GET['r']))) { 



	if($_rid) cookieset('_rid', abs(intval($_GET['r'])));



	Utility::Redirect( BASE_REF . "/deals.php?id={$id}");



}



if(isset($_GET['opt'])){
	
	need_login();
	$options = Table::Fetch('options',$_GET['opt']);
}



if(!$city['id']) $city = Table::Fetch('cities', $deals['city_id']);



if(!$city) { $city = array('id' => 0, 'name' => 'Multi-city Deal', ); }







$pagetitle = $deals['title'];







$discount_price = $deals['market_price'] - $deals['deals_price'];



$discount_rate = round(100 - $deals['deals_price']/$deals['market_price']*100);







$left = array();



$now = time();



$diff_time = $left_time = $deals['end_time']-$now;



$kick_time = $deals['begin_time']-$now;







$left_day = floor($diff_time/86400);



$left_time = $left_time % 86400;



$left_hour = floor($left_time/3600);



$left_time = $left_time % 3600;



$left_minute = floor($left_time/60);



$left_time = $left_time % 60;







/* progress bar size */



$bar_size = ceil(190*($deals['now_number']/$deals['min_number']));



$bar_offset = ceil(5*($deals['now_number']/$deals['min_number']));







$partner = Table::Fetch('partner', $deals['partner_id']);







/* other deals */



if (abs(intval($INI['system']['sidedeals'])) ) {



	if($city['id']) {

		$strWhereClause	=	"(city_id = '0' OR find_in_set({$city['id']},city_id))";

	} else {

		$strWhereClause	=	"city_id = '0'";

	}

	$oc	=	"id <> {$id} and begin_time < {$now} and end_time > {$now} and (stage = 'approved' OR stage = '1-featured') and $strWhereClause";			



	$others = DB::LimitQuery('deals', array(

				'condition' => $oc,

				'order' => 'ORDER BY end_time ASC',

				'size' => abs(intval($INI['system']['sdnumber'])),

				));



}







$deals['state'] = deals_state($deals);



/* your order */



if ($login_user_id && 0==$deals['close_time']) {



	$order = DB::LimitQuery('order', array(



		'condition' => array(



			'deals_id' => $id,



			'user_id' => $login_user_id,



			'state' => 'unpay',



		),



		'one' => true,



	));



}



/* end order */







if (abs(intval($INI['charity']['showcharity']))==1) {



include(dirname(__FILE__) . '/functions/counter.php');



$deals['contentsp'] = $contentsp;



$deals['contentso'] = $contentso;



$deals['contentsc'] = $contentsc;



$deals['charity1'] = $INI['charity']['charopa'];



$deals['charity2'] = $INI['charity']['charopb'];



$deals['charity3'] = $INI['charity']['charopc'];



$deals['contentcsold'] = round($contentcsold);



$deals['contentdsaved'] = round($contentdsaved);



$deals['contentddonated'] = round($contentddonated);



}



$subs_id=1;



$deals['userreview'] = stripslashes($deals['userreview']);



$deals['systemreview'] = stripslashes($deals['systemreview']);

















if (abs(intval($INI['display']['showmoredeals']))==1) {



	$daytime = time();



		$morecond = array( 



				'city_id' => array(0, abs(intval($city['id']))),



				"id <>  {$deals[id]}",



				//'OR' => array(



				//	"now_number >= min_number",



				//	"end_time > {$daytime}",



				//	),



				);











	$count = Table::Count('deals', $morecond);



	$now = time();



	$moredeals = DB::LimitQuery('deals', array(



		'condition' => $morecond,



		'order' => 'ORDER BY stage ASC, end_time ASC, begin_time ASC, id ASC',



		'offset' => $offset,



		'stage' => '1-featured,approved',







	));



	$livecounter = 0;



	$missedcounter = 0;



	foreach($moredeals AS $id=>$two){



		if ($two['end_time'] > $now && $two['state'] != 'soldout') {



			$two['picclass'] = 'isopen';



			$livecounter += 1;



		}



		else {



			$two['picclass'] = 'soldout';



			$missedcounter += 1;



		}



		$moredeals[$id] = $two;



	}



}

/** Added patch for Deal options **/
if($deals) {
	$strcondition	= " deals_id= '".$deals['id']."'";
	$deals['strOptions'] = DB::LimitQuery('options', array(
		'condition' => $strcondition,
		'order' => 'ORDER BY id ASC',
	));	
	for($k=0;$k<count($deals['strOptions']);$k++) {  
		$deals['strOptions'][$k]['strOptionTitle']	=	substr($deals['strOptions'][$k]['title'],0,60);
	}
}
/** Added patch for Deal options **/


include template('deals_view');



}