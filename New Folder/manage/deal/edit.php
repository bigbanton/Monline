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

require_once(dirname(dirname(dirname(__FILE__))) . '/facebook-connect.php');


$ob_content = ob_get_clean();
$base=BASE_REF;
need_dealer();
$module='deal';
//fb feed
//BASE_REF. "/manage/deal/edit.php?id={$deals['id']}

//--end fb feed
$id = abs(intval($_GET['id']));

if (!$id || !$deals = Table::Fetch('deals', $id)) {
	
	Utility::Redirect( BASE_REF . '/manage/deal/create.php');

}

$facebook = new FacebookConnect(array(

  	'appId' => $INI['system']['fbappid'],

  	'secret' => $INI['system']['fbsecid'],
        'cookie' => true,
	));
$popup=false;
$os=array('1-featured','approved');
if (in_array($deals['stage'],$os) && isset($_GET['fbfeed']) && $_GET['fbfeed']=='yes' && $INI['system']['fbpageid'] && $deals['fbcheck']=='on') {
  if($INI['system']['fbpageid']){
$popup=true;
}

 $loginUrl = $facebook->getLoginUrlFeed();

 $fb_id= $facebook->getUser();
  
  if($fb_id) {
	  
  try {
         if(fb_id){
              $post = array('name'=>$deals['title'],'description'=>$deals['title'],'picture'=> $domain.'/image.php?img=/'.$deals['image'],
              'link'=>$domain .'/deals.php?id='.$deals['id']);
 	     $facebook ->api('/'.$INI['system']['fbpageid'].'/feed','POST',$post);

         }

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $popup=true;
        $login_url = $facebook->getLoginUrl( array(
                       'scope' => 'publish_stream'
                       )); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   

  }
}

$deal_details = DB::LimitQuery('deal_details', array('condition'=>array('deal_id' => $id,),));

$deal_locations = DB::LimitQuery('deal_locations', array('condition'=>array('deal_id' => $id,), 'order'=>'ORDER BY id ASC'));

$deal_locations_count = count($deal_locations);

$action = $_GET['action']; //Get defined action

$image = $_GET['image']; //Action on the product image



if ($action == 'remove' && $image) {

$imgpath = $deals['image'.$image];

	if ($deals['image2'] && $image < 2) { //Move image up

		$deals['image1'] = $deals['image2'];

		$image = 2;

		}

$deals['image'.$image]='';

Table::UpdateCache('deals', $deals['id'], array(

			'image1' => $deals['image1'],

			'image2' => $deals['image2'],

		));

		

$deleteimg = remove_prod_image(DIR_BACKEND . '/themes/deals/' . $imgpath);

		

			if ($deleteimg) Session::Set('notice', TEXT_EN_PRODUCT_IMAGE_HAS_BEEN_REMOVED_EN);

			Utility::Redirect( BASE_REF. "/manage/deal/edit.php?id={$deals['id']}");

}


$langcondition = array('deleted' => '0','status'=>'enabled');
$languages = DB::LimitQuery('language', array(
			'condition' => $langcondition,
			'order' => 'ORDER BY id ASC',
			));
			
			
$deals1['begin_time'] = $deals['begin_time'];
	$deals1['end_time'] = $deals['end_time']; 
	$deals1['expire_time'] = $deals['expire_time'] ;
if ($_POST) {
	$deals1['begin_time'] = strtotime($_POST['begin_time']);
	$deals1['end_time'] = strtotime($_POST['end_time']);
	$deals1['expire_time'] = strtotime($_POST['expire_time']);


if (!$_POST['commission']) $_POST['commission'] = $login_partner['commission'];

		$location_enabled = $_POST['enabled'];
		$location_address = $_POST['location'];
		$location_lat = $_POST['lat'];
		$location_lng = $_POST['lng'];
		$location_html = $_POST['html'];
//		print_r($location_enabled);exit;

	$strError = 0;

	if(is_manager()) {
		if(empty($_POST['commission']) && !is_numeric($_POST['commission']) || $_POST['commission'] < 0 || $_POST['commission']>100 ){ //to validate the commission value
			$strError = 1;
			Session::Set('error', 'Please enter the valid commission value');
		}
	}


	if(empty($_POST['name'])) {
			$strError = 1;
			Session::Set('error', 'Deal name cannot be blank');
	}

   if($_POST['market_price']<$_POST['deals_price'])// Add the patch For deal price validation
   {
	   $strError=1;
	   Session::Set('error','value can be never less than to deals price');
   }

	if($strError==0) {

		$insert = array(
			'name', 'title', 'market_price', 'deals_price', 'end_time', 'begin_time', 'expire_time', 'min_number', 'max_number', 'summary', 'notice', 'conduser', 'per_number',
			'product', 'image', 'detail', 'userreview', 'systemreview', 'image1', 'image2', 'flv', 'card',
			'mobile', 'address', 'fare', 'express', 'delivery', 'credit', 'user_id', 'state', 'city_id', 'group_id', 'partner_id', 'stage', 'seokey', 'seodesc', 'commission','fbcheck'
			);


		if( $_POST['stage']=='draft' || $_POST['stage']=='pending' || $_POST['stage']=='returned' || $_POST['stage']=='canceled' ){		//can not edit commission if the deal is approved

			//print "level-1";

			if(($_POST['system']=='Y' && strtotime($_POST['end_time']) < time() && $_POST['now_number'] < $_POST['min_number']) || ($_POST['system']=='Y' && strtotime($_POST['end_time']) < time() && $_POST['now_number'] >= $_POST['min_number']) ){		// if the deal is tipped or failed cant edit commission

				//do nothing in insert array

				//print "level-2";					

			}else{

				//print "level-3";

				array_push($insert, 'commission');

			}

		}

	$_POST['city_id'] = ($_POST['city_id'][0]!=='') ? implode(',',$_POST['city_id']) : 0;

	$table = new Table('deals', $_POST);

	$table->SetStrip('name','summary', 'detail', 'systemreview', 'notice', 'userreview', 'product', 'title', 'seokey', 'seodesc');
	
	$table->title = $_POST['titleen'];
     // $table->fbcheck= $_POST['fbcheck'];
	$table->begin_time = strtotime($_POST['begin_time']);

	$table->end_time = strtotime($_POST['end_time']);

	$table->expire_time = strtotime($_POST['expire_time']);

	$table->image = upload_image('upload_image', $deals['image'], 'deals');

	$table->image1 = upload_image('upload_image1',$deals['image1'],'deals');

	$table->image2 = upload_image('upload_image2',$deals['image2'],'deals');



	$error_tip = array();

	if ( !$error_tip)  {

		if ( $table->update($insert) ) {
			
			if (abs(intval($INI['system']['dealalert']))== 2 && ($_POST["stage"]=='1-featured' || $_POST["stage"]=='approved')) {
				$indcall=1;
				$id = $deals_id;
				$action  = 'noticesubscribe';
				$nid = 0;
				$allow_flag = 'f8WE45Y^';
				require_once(dirname(dirname(dirname(__FILE__))) . '/functions/ajax/asmailer.php');
			}
			
			$details = array('deal_id', 'lang_id', 'title', 'summary', 'notice', 'detail', 'userreview');

			foreach ($languages as $language) {				
				$_POST['deal_id'] = $deals['id'];
				$_POST['lang_id'] = $language['id'];
				$_POST['title'] = $_POST['title'.$language['code']];
				$_POST['summary'] = $_POST['summary'.$language['code']];
				$_POST['notice'] = $_POST['notice'.$language['code']];
				$_POST['detail'] = $_POST['detail'.$language['code']];
				$_POST['userreview'] = $_POST['userreview'.$language['code']];

				if ($dealid = DB::LimitQuery('deal_details', array(
											'condition' => array('deal_id'=>$deals['id'],'lang_id'=>$language['id']),
				))) {			
					$detailstable = new Table('deal_details', $_POST);
					$detailstable->SetStrip('summary', 'detail', 'notice', 'userreview', 'title');
					$detailstable->SetPk('id',$dealid[0]['id']);
					$array = array('title' => stripslashes($deal_details['title']),
					'summary' => stripslashes($deal_details['summary']),
					'notice' => stripslashes($deal_details['notice']),
					'detail' => stripslashes($deal_details['detail']),
					'userreview' => stripslashes($deal_details['userreview']),
					);
					$detailstable->update($details);
				} else {
					
					$deal_create['deal_id'] = $deals_id;
					$deal_create['lang_id'] = $language['id'];
					$deal_create['title'] = ($deals['title'.$language['code']]) ? $deals['title'.$language['code']] : $deals['titleen'];
					$deal_create['summary'] = ($deals['summary'.$language['code']]) ? $deals['summary'.$language['code']] : $deals['summaryen'];
					$deal_create['notice'] = ($deals['notice'.$language['code']]) ? $deals['notice'.$language['code']] : $deals['noticeen'];
					$deal_create['detail'] = ($deals['detail'.$language['code']]) ? $deals['detail'.$language['code']] : $deals['detailen'];
					$deal_create['userreview'] = ($deals['userreview'.$language['code']]) ? $deals['userreview'.$language['code']] : $deals['userreviewen'];
					
					$createtable = new Table('deal_details', $_POST);
					$createtable->SetStrip('summary', 'detail', 'notice', 'userreview', 'title');
					$createtable->insert($details);
						
				}
			}

				
				if ($dealid = DB::LimitQuery('deal_locations', array(
											'condition' => array('deal_id'=>$deals['id']),
				))) {			
					foreach($dealid AS $one) Table::Delete('deal_locations', $one['id']);
				}
				
			for($z=0;$z<count($location_address);$z++) {
				$location = array('deal_id', 'address', 'lng', 'lat', 'html', 'stage');
				if (!$location_address[$z]) continue;			
				$deal_locations['deal_id']=$deals['id'];
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
			ZLog::Log($login_user_id, 'Deal Updated', 'Deal ID:'.$deals['id'] );
			# ACTIVITY LOG
					
			Session::Set('notice', 'Deal \'<span style="color:black">'. substr($_POST['name'],0, 30) . '...</span>\' updated successfully.');
					
			if(in_array($_POST['stage'],$os) && $INI['system']['fbpageid'] &&  $_POST['fbcheck']=='on'){
			$refURI =  BASE_REF. "/manage/deal/edit.php?id={$deals['id']}&fbfeed=confirm";
			}else{
				$refURI =  BASE_REF. "/manage/deal/index.php";
			}
			Utility::Redirect( $refURI );

		} else {

			Session::Set('error', 'System could not updated deals settings. Please check your database settings.');

		}

	}



	}





}



$groups = DB::LimitQuery('category', array(
			'condition' => array(),
			));
$groups = Utility::OptionArray($groups, 'id', 'name');



$partner = DB::LimitQuery('partner', array(

			'order' => 'ORDER BY id DESC',

			));

$partners = Utility::OptionArray($partner, 'id', 'title');

$partner_commission = $partner[$deals['partner_id']]['commission'];

$bizstageoptions = array(

		'draft' => 'Save as Draft',

		'canceled' => 'Cancel Deal',

		'pending' => 'Submit for Approval',

		);



$adminstageoptions = array(

		'draft' => 'Draft',

		'pending' => 'Pending',

		'returned' => 'Returned',

		'canceled' => 'Canceled',

		'approved' => 'Approved',

		'1-featured' => 'Approved + Featured Deal',

		);


if (is_partner()) {

	if ($deals['stage'] == 'approved') {

		Utility::Redirect( BASE_REF . '/manage/deal/index.php');

	}

include template('business_deals_edit');

}

else {

include template('manage_deals_edit');

}