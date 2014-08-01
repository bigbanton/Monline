<?php

/**
 * //License information must not be removed.
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @Architecture ### Secured  ###
 * @Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @License EULA License http://www.gripsell.com
 * @Author $Author: gripsell $
 * @Version $Version: 5.3.3 $
 * @Last Revision $Date: 2013-21-05 00:00:00 +0530 (Tue, 21 May 2013) $
 */
ob_start();
require_once(dirname(__FILE__) . '/app.php');
$ob_content = ob_get_clean();

if (abs(intval($INI['display']['tabbed']))) {
    $strClass = 'map';
    } else {
    $strClass = 'mapplain';
    } 

$partner_loc = $_GET['q'];
$partner_name = str_replace($partner_loc, '', $_GET['p']);

if ($id = $_GET['id']) {
    
    if ($id == 'all') {
        $now = time();
         $oc = array(
            "begin_time < {$now}",
             "end_time > {$now}",
             'stage' => array('1-featured', 'approved'),
            );
        
         $deals = DB::LimitQuery('deals', array(
                'condition' => $oc,
                ));
        
         $locations = array();
        
         foreach ($deals as $deal) {
            $deallocations = DB::LimitQuery('deal_locations', array('condition' => array('deal_id' => $deal['id'],), 'order' => 'ORDER BY id ASC'));
             if (!empty($deallocations)) $locations = array_merge((array)$locations, (array)$deallocations);
             } 
        
        // print_r($locations);
        } else {
        if ($_GET['isinsta'] == 1) {
            $table_loc = "insta";
             $deal_id = 'id';
            } else {
            $table_loc = "deal_locations";
             $deal_id = 'deal_id';
            } 
        $locations = DB::LimitQuery($table_loc, array(
                'condition' => array($deal_id => $id), 'order' => 'ORDER BY id DESC'
                ));
         } 
    } 

$zoom = (abs(intval($_GET['zoom'])))?abs(intval($_GET['zoom'])):$INI['system']['gmapzoom'];

$define_style = (isset($_GET['enlarge']))? 'height:510px':'';
$define_style = (isset($_GET['height'])) ? 'height:' . $_GET['height'] . 'px':$define_style;
$zoom = (isset($_GET['enlarge']))? 9:$zoom;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Google Map</title>
	<script type="text/javascript">
		var BASE_REF = "<?php echo BASE_REF;
?>";
	</script>
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/themes/css/tgsmap.css" type="text/css" media="screen" charset="utf-8" />
</head>

<body><div id="map" class="<?php echo $strClass;
?>" style="border:0px;<?php echo $define_style;
?>"></div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js"></script>
<script type="text/javascript" src="/themes/js/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/themes/css/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript">
  var marker, i;
  //Function creates a marker for given address and places it on the map
  function placeAddressOnMap(address, i) {
	  gc.geocode({'address': address}, function (res, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		map.setCenter(res[0].geometry.location);
		marker = new google.maps.Marker({
		  position: res[0].geometry.location,
		  map: map
		});
	  marker.setTitle(address);
	  attachAddressMessage(marker, i, address);

<?php if ($define_style) {
    ?>
		// Add a Circle overlay to the map.
        var circle = new google.maps.Circle({
          	map: map,
          	radius: 3000, // 30 km
			strokeColor: "#FF0000",
			strokeOpacity: 0.2,
			strokeWeight: 2,
			fillColor: "#FF0000",
			fillOpacity: 0.2	  
        });

        // Since Circle and Marker both extend MVCObject, you can bind them
        // together using MVCObject's bindTo() method.  Here, we're binding
        // the Circle's center to the Marker's position.
        // http://code.google.com/apis/maps/documentation/v3/reference.html#MVCObject
        circle.bindTo('center', marker, 'position');
		
		/*	var triangleCoords = [
				new google.maps.LatLng(25.774252, -80.190262),
				new google.maps.LatLng(18.466465, -66.118292),
				new google.maps.LatLng(32.321384, -64.75737),
				new google.maps.LatLng(25.774252, -80.190262)
		  ];	
		*/

<?php } 
?>

	  }
	  });
}
  
  
    function placeLocationOnMap(address,lat,lng, i,id) {
		map.setCenter(new google.maps.LatLng(lat, lng));
		marker = new google.maps.Marker({
		  draggable: false,
		  raiseOnDrag: false,
		  icon: image,
		  shadow: shadow,
		  shape: shape,
		  position: new google.maps.LatLng(lat, lng),
		  map: map
		});
	  marker.setTitle(address);
	  attachAddressMessage(marker, i, address,id);

<?php if ($define_style) {
    ?>
		// Add a Circle overlay to the map.
        var circle = new google.maps.Circle({
          	map: map,
          	radius: 3000, // 30 km
			strokeColor: "#FF0000",
			strokeOpacity: 0.2,
			strokeWeight: 2,
			fillColor: "#FF0000",
			fillOpacity: 0.2		  
        });

        // Since Circle and Marker both extend MVCObject, you can bind them
        // together using MVCObject's bindTo() method.  Here, we're binding
        // the Circle's center to the Marker's position.
        // http://code.google.com/apis/maps/documentation/v3/reference.html#MVCObject
        circle.bindTo('center', marker, 'position');
		
		/*	var triangleCoords = [
				new google.maps.LatLng(25.774252, -80.190262),
				new google.maps.LatLng(18.466465, -66.118292),
				new google.maps.LatLng(32.321384, -64.75737),
				new google.maps.LatLng(25.774252, -80.190262)
		  ];
		*/

<?php } 
?>

	}

  function attachAddressMessage(marker, number, message, id) {
	//  var infowindow = new google.maps.InfoWindow(
	//	  { content: '<?php echo $partner_name;
?>'+message,
	//		//size: new google.maps.Size(50,50)
	//	  });
	// google.maps.event.addListener(marker, 'click', function() {
	//	infowindow.open(map,marker);
	// });
		
		message =  '<b><?php echo $partner_name;
?></b>'+message;
		var boxText = document.createElement("div");
			boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: black; padding: 5px;color:#fff;font-family:arial;font-size:12px;";
			boxText.innerHTML = message;

			var myOptions = {
				 content: boxText
				,disableAutoPan: false
				,maxWidth: 0
				,pixelOffset: new google.maps.Size(-90, 0)
				,zIndex: null
				,boxStyle: { 
				  //background: "url('tipbox.gif') no-repeat",
				  opacity: 0.85
				  ,width: "180px"
				 }
				,closeBoxMargin: "10px 2px 2px 2px"
				,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
				,infoBoxClearance: new google.maps.Size(1, 1)
				,isHidden: false
				,pane: "floatPane"
				,enableEventPropagation: false
			};

			google.maps.event.addListener(marker, "click", function (e) {
				<?php if ($_GET['infobox'] !== 'html') {
    ?> ib.open(map, this);                        
				<?php } else {
    ?>
									$.fancybox.showActivity();
									
                                    $.fancybox({
										href: "/widget.php?id="+id,
										'width'				: 660,
										'height'			: 290,
										'autoScale'     	: true,
										'transitionIn'		: 'fade',
										'transitionOut'		: 'fade',
										'type'				: 'iframe',
										'scrolling' 		: 'no'
										// other options
									});
									$.fancybox.hideActivity();
				<?php } 
?>
			});
			
			var ib = new InfoBox(myOptions);
			<?php if (!$define_style) {
    ?>ib.open(map, marker);		<?php } 
?>	
			
	}
  //Addresses you want to display on the map
  //var address1 = '<?php echo $partner_loc;
?>';
  //var address2 = '1000 W. Taylor Street Chicago, IL 60607';
  //var address3 = '800 W Harrison Street Chicago, IL 60607';

  //Create a map with zoom factor, center location and map type
  var gc = new google.maps.Geocoder();
  
  var infowindow = new google.maps.InfoWindow();

  var map = new google.maps.Map(document.getElementById('map'), {
	zoom: <?php echo $zoom;
?>,//,
	scrollwheel: false,
	center: new google.maps.LatLng(39.38,-99.83),
	mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  var image = new google.maps.MarkerImage(
  'themes/css/map-icons/image.png',
  new google.maps.Size(32,32),
  new google.maps.Point(0,0),
  new google.maps.Point(16,32)
	);
	
	var shadow = new google.maps.MarkerImage(
	  'themes/css/map-icons/shadow.png',
	  new google.maps.Size(52,32),
	  new google.maps.Point(0,0),
	  new google.maps.Point(16,32)
	);
	
	var shape = {
	  coord: [20,0,22,1,23,2,24,3,25,4,25,5,26,6,26,7,26,8,26,9,26,10,26,11,26,12,26,13,26,14,25,15,25,16,25,17,24,18,24,19,23,20,23,21,22,22,22,23,21,24,21,25,20,26,20,27,19,28,18,29,18,30,17,31,15,31,14,30,13,29,13,28,12,27,11,26,11,25,10,24,10,23,9,22,9,21,8,20,8,19,7,18,7,17,7,16,6,15,6,14,5,13,5,12,5,11,5,10,5,9,5,8,5,7,6,6,6,5,7,4,8,3,9,2,10,1,12,0,20,0],
	  type: 'poly'
	};
	
	var PlotLocation = new Array();
  
  //Using function place the address markers on the map
  //placeAddressOnMap(address1,0);
  //placeAddressOnMap(address2);
  //placeAddressOnMap(address3);
 <?php
 $index = 1;
 $centerboolean = 0;
 $lat = '';
 $lng = '';
 foreach($locations as $location) {
    echo "\n";
     // echo "PlotLocation[0] = {$location['lat']};\n";
    // echo "PlotLocation[1] = {$location['lng']};\n";
    if (isset($_GET['centerid']) && $_GET['centerid'] == $location['id']) {
        $lat = $location['lat'];
         $lng = $location['lng'];
         $html = $location['html'];
         $centerboolean = 1;
         continue;
         } 
    if ($_GET['isinsta'] == 1) {
        $location['deal_id'] = $location['id'];
        } 
    // if (!isset($_GET['centerid']) && (($index==count($locations)) && !$centerboolean)) {
    // $lat = $location['lat'];
    // $lng = $location['lng'];
    // }
    echo "placeLocationOnMap('{$location['html']}',{$location['lat']}, {$location['lng']},{$index},{$location['deal_id']});\n\n";
     $index++;
     } 

if ($centerboolean) {
    echo "placeLocationOnMap('{$html}',{$lat}, {$lng},{$index},{$location['deal_id']});\n\n";
     $centerboolean = 0;
     } 
?>
  </script>

</body>
</html>
