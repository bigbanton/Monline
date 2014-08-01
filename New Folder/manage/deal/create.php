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
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_dealer();
$ob_content = ob_get_clean();
//error_reporting(E_ALL);
$module='deal';
if (isset($_REQUEST['addtoloc'])) {
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$_REQUEST['address'].'&sensor=false');
		$output= json_decode($geocode);									
		echo $output->results[0]->geometry->location->lat ."------". $output->results[0]->geometry->location->lng;
		exit();	
}


if (is_partner()) {
$partner_id = abs(intval($_SESSION['partner_id']));
$login_partner = Table::Fetch('partner', $partner_id);
}

$langcondition = array('deleted' => '0','status'=>'enabled');
$languages = DB::LimitQuery('language', array(
			'condition' => $langcondition,
			'order' => 'ORDER BY id ASC',
			));

$deals1['begin_time'] = strtotime('+0 days');
	$deals1['end_time'] = strtotime('+5 days'); 
	$deals1['expire_time'] = strtotime('+3 months +1 days');
if ($_POST) {
	$deals1['begin_time'] = strtotime($_POST['begin_time']);
	$deals1['end_time'] = strtotime($_POST['end_time']);
	$deals1['expire_time'] =  strtotime($_POST['expire_time']);
	$deals = $_POST;

if (!$_POST['commission']) $_POST['commission'] = $login_partner['commission'];

	$strError = 0;

	if(is_manager()) {
		if(empty($_POST['commission']) && !is_numeric($_POST['commission']) || $_POST['commission'] < 0 || $_POST['commission']>100 ){ //to validate the commission value
			$strError = 1;
			Session::Set('error', 'Please enter the valid commission value');
		}
	}
	
	if($_POST['location'][0]=='' || $_POST['location'][0]=='Address or Zip Code'){
			$strError = 1;
			Session::Set('error', 'Deal location cannot be empty');
	}
	
	if($_POST['market_price']<$_POST['deals_price'])// Add the Patch For deal price validation
	{
	   $strError=1;
	   Session::set('error','Value can never be less than deals price');	
	}

	if($strError==0) {
		$location_enabled = $_POST['enabled'];
		$location_address = $_POST['location'];
		$location_lat = $_POST['lat'];
		$location_lng = $_POST['lng'];
		$location_html = $_POST['html'];
//		print_r($location_enabled);exit;
		$insert = array(
			'name', 'title', 'market_price', 'deals_price', 'end_time', 'begin_time', 'expire_time', 'min_number', 'max_number', 'summary', 'notice', 'conduser', 'per_number',
			'product', 'image', 'detail', 'userreview', 'systemreview', 'image1', 'image2', 'flv', 'card',
			'mobile', 'address', 'fare', 'express', 'delivery', 'credit', 'user_id', 'state', 'city_id', 'group_id', 'partner_id', 'stage', 'seokey', 'seodesc','commission', 'conduser','commission','mdoption','fbcheck'
			);

		//$_POST['city_id'] = $c_ids = implode(',',$_POST['city_id']);
		$_POST['city_id'] =  $c_ids = ($_POST['city_id'][0]!=='') ? implode(',',$_POST['city_id']) : 0; // patch for city selected issue
		
		$deals['user_id'] = $login_user_id;
		$deals['state'] = 'none';
		$deals['begin_time'] = strtotime($deals['begin_time']);
		//$deals['city_id'] = abs(intval($deals['city_id']));// echo $deals['end_time'] . ' XX ';
		 $deals['city_id'] = $_POST['city_id'];  // patch for city selected issue
		// $deals['fbcheck']= $_POST['fbcheck'];
		$deals['end_time'] = strtotime($deals['end_time']);
		//echo $deals['end_time'] ."/n"; echo "time == " . date('l dS \o\f F Y h:i:s A', $deals['end_time']); echo"/n/n". "Not allowed in the demo"; exit;
		$deals['expire_time'] = strtotime($deals['expire_time']);
		$deals['image'] = upload_image('upload_image', null, 'deals');
		$deals['image1'] = upload_image('upload_image1', null, 'deals');
		$deals['image2'] = upload_image('upload_image2', null, 'deals');
		$_POST['summary'] 	= $deals['summary'] 		= $_POST['summaryen'];
		$_POST['detail']		= $deals['detail'] 		= $_POST['detailen'];
		$_POST['notice'] 		= $deals['notice'] 		= $_POST['noticeen'];
		$_POST['userreview'] 	= $deals['userreview'] 	= $_POST['userreviewen'];
		$_POST['title'] 		= $deals['title'] 			= $_POST['titleen'];
		
		$table = new Table('deals', $deals);
		$table->SetStrip('summary', 'detail', 'systemreview', 'notice', 'userreview', 'product', 'title', 'seokey', 'seodesc');
	
		if ($deals_id = $table->insert($insert) ) {
			if (abs(intval($INI['system']['dealalert']))== 2 && ($_POST['stage']=='1-featured' || $_POST['stage']=='approved')) {
				$indcall=1;
				$id = $deals_id;
				$action  = 'noticesubscribe';
				$nid = 0;
				$allow_flag = 'f8WE45Y^';
				require_once(dirname(dirname(dirname(__FILE__))) . '/functions/ajax/asmailer.php');
			 // echo ' ...Yes';
			}
		
			foreach ($languages as $language) {
				$details = array('deal_id', 'lang_id', 'title', 'summary', 'notice', 'detail', 'userreview');
				
				$deal_details['deal_id'] = $deals_id;
				$deal_details['lang_id'] = $language['id'];
				$deal_details['title'] = ($deals['title'.$language['code']]) ? $deals['title'.$language['code']] : $deals['titleen'];
				$deal_details['summary'] = ($deals['summary'.$language['code']]) ? $deals['summary'.$language['code']] : $deals['summaryen'];
				$deal_details['notice'] = ($deals['notice'.$language['code']]) ? $deals['notice'.$language['code']] : $deals['noticeen'];
				$deal_details['detail'] = ($deals['detail'.$language['code']]) ? $deals['detail'.$language['code']] : $deals['detailen'];
				$deal_details['userreview'] = ($deals['userreview'.$language['code']]) ? $deals['userreview'.$language['code']] : $deals['userreviewen'];
				
				$detailstable = new Table('deal_details', $deal_details);
				$detailstable->SetStrip('summary', 'detail', 'notice', 'userreview', 'title');
				$detailstable->insert($details);
			}
			
			for($z=0;$z<count($location_address);$z++) {
				$location = array('deal_id', 'address', 'lng', 'lat', 'html', 'stage');
				if (!$location_address[$z]) continue;
				$deal_locations['deal_id']=$deals_id;
				$deal_locations['address']=$location_address[$z];
				$deal_locations['lng']=$location_lng[$z];
				$deal_locations['lat']=$location_lat[$z];
				$deal_locations['stage']=$location_enabled[$z];
				$deal_locations['html']=$location_html[$z];
				
				$locationtable = new Table('deal_locations', $deal_locations);
				$locationtable->SetStrip('html', 'address');
				$locationtable->insert($location);
			}

			# ACTIVITY LOG
			ZLog::Log($login_user_id, 'Deal Added', 'Deal Type:Regular, Deal ID:'.$deals_id );
			# ACTIVITY LOG
		
			// echo ' ...No';
			Utility::Redirect( BASE_REF . "/manage/deal/index.php");
		}

	}



}
else {
	$profile = Table::Fetch('leader', $login_user_id, 'user_id');
	//1
	$deals = array();
	$deals['user_id'] = $login_user_id;
	$deals['begin_time'] 	= date('Y/m/d H:i',strtotime('+1 days'));
	$deals['end_time'] 		= date('Y/m/d H:i',strtotime('+2 days')); 
	$deals['expire_time'] 	= date('Y/m/d H:i',strtotime('+3 months +1 days'));
	$deals['min_number'] = 10;
	$deals['per_number'] = 1;
	$deals['market_price'] = 1;
	$deals['deals_price'] = 1;
	//3
	$deals['delivery'] = 'coupon';
	$deals['address'] = $profile['address'];
	$deals['mobile'] = $profile['mobile'];
	$deals['fare'] = 5;
	$deals['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
	$deals['mdoption']=$_POST['mdoption'];
}

$groups = DB::LimitQuery('category', array(
			'condition' => array(),
			));
$groups = Utility::OptionArray($groups, 'id', 'name');

if (is_partner()) {
$condition = array(
					'id' => $partner_id,
				);
$partner = DB::LimitQuery('partner', array(
			'condition' => $condition,
			));
} else {
$partner = DB::LimitQuery('partner', array(
			'order' => 'ORDER BY id DESC',
			));

$partners = Utility::OptionArray($partner, 'id', 'title');
}

$partner_commission = $partner[0]['commission'];

$selector = 'create';


$bizstageoptions = array(
		'draft' => 'Save as Draft',
		'pending' => 'Submit for Approval',
		);

$adminstageoptions = array(
		'draft' => 'Draft',
		'pending' => 'Pending',
		'approved' => 'Approved',
		'1-featured' => 'Approved + Featured Deal',
		);


if (is_partner()) {
include template('business_deals_create');
}
else {
include template('manage_deals_create');
}