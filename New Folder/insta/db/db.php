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

$ob_content = ob_get_clean();

//need_dealer();
  //Query String Variables
  $extendLat = $_GET['extendLat'];
  $extendLng = $_GET['extendLng'];
  $southWestLat = $_GET['swLat'] - $extendLat;
  $northEastLat = $_GET['neLat'] + $extendLat;
  $southWestLng = $_GET['swLng'] - $extendLng;
  $northEastLng = $_GET['neLng'] + $extendLng;
  $cat = $_GET['cat'];

	if ($_GET['swLng'] > 0) {
		$swlngcond = "lng > '{$southWestLng}'";
	} else {
		$swlngcond = "lng < '{$southWestLng}'";
	}
	
	if ($_GET['neLng'] > 0) {
		$nelngcond = "lng < '{$northEastLng}'";
	} else {
		$nelngcond = "lng > '{$northEastLng}'";
	}
	$now = time();
	$condition = array(
				"lat > '{$southWestLat}'",
				"lat < '{$northEastLat}'",
				$nelngcond,
				$swlngcond,
				'product' => $cat,
				"end_time > ".$now,
				'now_number <= max_number'  // Add the patch when the deal is over it is still display
					
				);

	$deals = DB::LimitQuery('insta', array(
	'condition' => $condition,
		));

	$allcats = cat2arr();
	foreach ($allcats as $category) {
		list($name, $desc, $_) = explode("##", $category);
		$cat2icon[$name] = $_;
	}

      header("Content-type: text/xml");
      $xml_output = "<?xml version=\"1.0\"?>\n";
      $xml_output .= "<markers>\n";
      foreach ($deals as $deal) {
		
						$deal_info = array('title','notice');
						$deal_details = DB::GetTableRow('insta_details', array('lang_id'=>$syslang['id'], 'deal_id'=>$deal['id']));
						foreach ($deal_info as $param) {
							$deal[$param] = ($deal_details[$param])?$deal_details[$param]:$deal[$param];
						}


        $category = DB::GetTableRow('category', array('id'=>$deal['product']));
		$category = $category['name'];
        $icon = $cat2icon[$category];
		$view = isset($_GET['view']) ? $_GET['view'] : 'hybrid';
		
		$list_html = '<div class="'. strtolower(htmlentities($category,ENT_QUOTES,'UTF-8')) . 'list" style="border: 1px solid #B8CB80; margin: 10px 0px 5px 0px; padding:5px; width: 660px; font-family:\'Lucida Sans\', \'Lucida Sans Regular\', \'Lucida Grande\', \'Lucida Sans Unicode\', Geneva, Verdana, sans-serif; font-size:12px; float:left; clear:both  ">
	<div style="float:left;width: 200px; height: 100px; padding:5px; position:relative;">
	<div style="position:absolute;left:-5px; top:-5px;z-index:99; height:48px;width:100px;background:url(http://demopro.gripsell.com/insta/icons/'.$icon.'.png) no-repeat 0 0;padding-left:32px;padding-top:6px;"><div style="background:#575F38;color:#fff;font-weight:bold;text-align:center">'.htmlentities($category,ENT_QUOTES,'UTF-8').'</div></div>
	<img src="/image.php?img=/'.$deal['image'].'" width="190" height="130" style="padding:2px;border:1px solid #ccc" />
	</div>
	<div style="width: 440px; float:right; padding:5px">
 	   <div style="padding:5px; background-color: #B8CB80;">
		   <strong>'.htmlentities($deal["title"],ENT_QUOTES,'UTF-8').'</strong></div>
		<div style="padding:5px; color: #7B7B7B;">
		 '.htmlentities($deal['notice'],ENT_QUOTES,'UTF-8').'</div>
		<div style="padding:5px">
  		  '.htmlentities($deal['address'],ENT_QUOTES,'UTF-8').'</div>
  		  <div style="padding:5px">
  		  <div style="padding:0px">
	  		<div style="width: 280px; float:left">
			    <span class="text">Redeem between <span style="color:#F30; font-size:10px;">'. date('h:i A', $deal['begin_time']) . ' ('.date('d M, Y', $deal['begin_time']).')  - ' . date('h:i A', $deal['end_time'])  . ' ('.date('d M, Y', $deal['end_time']).')</span> or we\'ll automatically credit back the amount.</span></div>
			    <div style="width: 81px; float:right">
			    <div class="instabutton">

<span class="h1list"> <a href="/manage/deals/buy.php?id='.$deal["id"].'&isinsta=1">BUY</a></span>
</div>
	   </div>
	  </div>
	  </div>
 </div>
</div>
';
		
		
		$html = '<div class="instabox">
  <div id="">
    
  <div class="instaimg"><img src="/image.php?img=/'.$deal['image'].'" width="140" height="86" /></div>



</div>


<div class="heading_text">'.htmlentities($deal["title"],ENT_QUOTES,'UTF-8').'</div>

<div class="sub_text">
 '.htmlentities($deal['notice'],ENT_QUOTES,'UTF-8').'</div>
 
 <div class="othertext"><span class="text">'.htmlentities($deal['address'],ENT_QUOTES,'UTF-8').'</span></div>
 
 
 <!--button area start-->
<div class="button_area">
<div style="width:50px;" class="backgroundline"></div>
<div class="instabutton">

<span class="h1font"> <a href="/manage/deals/buy.php?id='.$deal["id"].'&isinsta=1">BUY</a></span>
</div>

<div style="width:325px;" class="backgroundline">
<span class="text">Redeem between <span style="color:#F30; font-size:10px;">'. date('h:i A', $deal['begin_time']) . ' ('.date('d M, Y', $deal['begin_time']).')  - ' . date('h:i A', $deal['end_time'])  . ' ('.date('d M, Y', $deal['end_time']).')</span></span>
</div>
</div>
 <!--button area end-->
<div class="btnarea_2">
<div class="button_shadow"></div>
<div class="text">or we\'ll automatically credit back the amount.</div>
</div>
';

        $xml_output .= '<marker lat="' . $deal['lat'] . '" lng="' . $deal['lng'] . '" title="Insta Deals" address="' . $deal['address'] . '" url="' . htmlentities($deal['url']) . '" html="' . htmlentities($html, ENT_QUOTES,'UTF-8') . '" category="' . $deal['category'] . '" icon="' . $icon . '" listhtml="' . htmlentities($list_html, ENT_QUOTES,'UTF-8') . '" view="' . $view . '" />';
      }
      $xml_output .= '<marker lat="0" lng="0" title="Blank" address="" url="" html="" category="' . $deal['category'] . '" icon="' . $icon . '"/>';
      $xml_output .= "</markers>";
      echo $xml_output;
      $dbh = null;
  
function fields($variable) {
	$fields = array(
// Field Mappings
			'latitude' 	=> 'lat',
			'longitude' 	=> 'lng',
			'title' 	=> 'title',
			'address' 	=> 'address',
			'url' 	=> 'url',
			'html' 	=> 'html',
			'category' 	=> 'category',
			'icon' 	=> 'marker'
);
	return $fields[$variable];
}
?>