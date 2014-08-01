//POI Auto Map v4.0.0 11Jan2011 - (c) Gavin Smith 2010 - 2011 - http://codecanyon.net/item/point-of-interest-poi-auto-map/101599

//Commercial License

//Google Search Based POIs require you to sign up for your Google AJAX Key Here: http://code.google.com/apis/ajaxsearch/signup.html

google.load("search", "1");

// Map Configuration

var defaultAddress = "Eltham, Victoria";

var defaultHTML = "<strong>Eltham,<br/>Victoria, Australia</strong>";

var defaultZoomLevel = 15; //Larger Number = Higher Zoom 

var infoHTML = "<h4>Instructions</h4><p>Drag the map or enter an address above to view a different area's information. Click on the list of categories to show points of interest on the map. Click on each point to see more detail.</p>";

var searchControls = true;

var mapDivID = "map";

var categoriesList = "poiList";

var directionsMode = 'walking'; //change to 'walking' WALKING for walking directions

//Database Bounds Search Extension

var extendLat = 0.05;

var extendLng = 0.005;

//Main Marker Configuration

var mainIconWidth = 43;

var mainIconHeight = 50;

var mainAnchorPointX = 17;

var mainAnchorPointY = 49;

// Icon Configuration

var iconPath = "icons/";

var iconWidth = 32;

var iconHeight = 37;

var anchorPointX = 16;

var anchorPointY = 34; 

var dbPath = "db/";

var xmlExtra = false; //runs if true: xmlPost(xml);

var mapExtra = false; //runs if true: mapPost(xml);

/*-------------------------------*/

/*  Do Not edit below this line  */

/*-------------------------------*/

var classAdder;

var markerGroups = "";

var map = null;

var searchCenter;

var addressSet;

var overlayControls;

var wikiLayer;

var photoLayer;

var startAddress;

var directions;

var myPano;

var jsonGroups;

var mapDiv;

var mapLoading;

var ddBoxDiv;

var batchGeoLat = [];

var batchGeoLng = [];

var lastInfoWindow;

var directionDisplay;

var directionsService;

function setupAddress() {

  if (typeof poiAddress === 'undefined') {

    startAddress = defaultAddress;

  } else {

    startAddress = poiAddress;

  }

  if (typeof poiHTML === 'undefined') {

    markerHTML = defaultHTML;

  } else {

    markerHTML = poiHTML;

  }

  if (typeof poiZoomLevel === 'undefined') {

    zoomLevel = defaultZoomLevel;

  } else {

    zoomLevel = poiZoomLevel;

  }

}

function centerBox(child, parent) {

  var h = document.getElementById(child).offsetHeight;

  var a = Math.round(parseInt(document.getElementById(parent).offsetHeight, 10) / 2);

  var b = Math.round(h / 2);

  var c = (a - b) + "px";

  document.getElementById(child).style.top = c;

  var w = document.getElementById(child).offsetWidth;

  var x = Math.round(parseInt(document.getElementById(parent).offsetWidth, 10) / 2);

  var y = Math.round(w / 2);

  var z = x - y;

  document.getElementById(child).style.left = z + "px";

}

function hideInfoBox() {

  document.getElementById("infoBox").style.display = "none";

}

function infoBox() {

  mapLoading = document.createElement('div');

  mapLoading.style.zIndex = 10;

  mapLoading.setAttribute('id', 'mapLoading');

  mapDiv.appendChild(mapLoading);

  centerBox("mapLoading", "map");

  if (infoHTML != "") {

    var infoBoxDiv = document.createElement('div');

    infoBoxDiv.setAttribute('id', 'infoBox');

    mapDiv.appendChild(infoBoxDiv);

    infoBoxDiv.innerHTML = infoHTML;

    infoBoxDiv.style.position = "absolute";

	infoBoxDiv.style.zIndex = "1";

    infoBoxDiv.style.top = (mapDiv.offsetHeight - infoBoxDiv.offsetHeight) + "px";

    var infoBoxClose = document.createElement('a');

    infoBoxClose.setAttribute('id', 'infoBoxClose');

    infoBoxDiv.appendChild(infoBoxClose);

    infoBoxClose.style.position = "absolute";

    infoBoxClose.style.top = "4px";

    infoBoxClose.style.left = "4px";

    infoBoxClose.onclick = function() { 

		hideInfoBox();

	};

  }

  var overlayDiv = document.createElement('div');

  overlayDiv.setAttribute('id', 'overlayControl');

  mapDiv.appendChild(overlayDiv);

  overlayDiv.style.position = "absolute";

  overlayDiv.style.zIndex = 2;

  

  var overlayHTML = "";

  if (searchControls === true) {

    overlayHTML = overlayHTML + '<form id="searchForm" action="#" onsubmit="findAddress(this.address.value); return false">';

    overlayHTML = overlayHTML + '<input id="searchTxt" type="text" size="20" name="address" value="Enter a City or Address" />';

    overlayHTML = overlayHTML + '<input id="searchButton" type="submit" value="Go" /> </form>';

  }

  overlayDiv.innerHTML = overlayHTML;

}

function createMarker(latlng, index, html, category, icon) {

    var myHtml;

	if ( icon === undefined ) {

      icon = category;

   }

  if (category == "pin") {

		if (markerGroups["pin"]) {

		for (var i = 0; i < markerGroups["pin"].length; i++) {

		  markerGroups["pin"][i].setMap(null);

		}

		markerGroups["pin"].length = 0;

		}

	  var image = new google.maps.MarkerImage(iconPath + category + ".png",

      new google.maps.Size(mainIconWidth, mainIconHeight),

      new google.maps.Point(0,0),

      new google.maps.Point(mainAnchorPointX, mainAnchorPointY));

	  

	  var shadow = new google.maps.MarkerImage( iconPath + category + "-shadow.png",

      new google.maps.Size(mainIconWidth, mainIconHeight),

      new google.maps.Point(0,0),

      new google.maps.Point(mainAnchorPointX, mainAnchorPointY));

	  var marker = new google.maps.Marker({

        position: latlng,

        map: map,

        shadow: shadow,

        icon: image

    });

	  markerGroups["pin"].push(marker);

	  var infowindow = new google.maps.InfoWindow({

        content: html

    });

	  google.maps.event.addListener(marker, 'click', function() {

      infowindow.open(map,marker);

    });

  } else {

  if (icon == ""){ icon = category; }

  	  var image = new google.maps.MarkerImage(iconPath + icon + ".png",

      new google.maps.Size(iconWidth, iconHeight),

      new google.maps.Point(0,0),

      new google.maps.Point(anchorPointX, anchorPointY));

	  

	  var shadow = new google.maps.MarkerImage( iconPath + icon + "-shadow.png",

      new google.maps.Size(iconWidth, iconHeight),

      new google.maps.Point(0,0),

      new google.maps.Point(anchorPointX, anchorPointY));

}

  if (category == "xml") {

  } else {

	  var marker = new google.maps.Marker({

        position: latlng,

        map: map,

        shadow: shadow,

        icon: image,

		title: category

    });

	  markerGroups[category].push(marker);

	  var infowindow = new google.maps.InfoWindow({

        content: html

    });

	  google.maps.event.addListener(marker, 'click', function() {   

	  if (lastInfoWindow) lastInfoWindow.close();

      infowindow.open(map,marker);

	  lastInfoWindow = infowindow;

    });

  }

}

function createHTML(title, url, address1, address2, website, phone, lat, lng) {

  var onClickSVCode = '"' + lat + '","' + lng + '","' + address1 + '","' + address2 + '"';

  var onClickDDCode = '"' + address1 + ' ' + address2 + '"';

  var finalHTML;

  finalHTML = '<div class="gs-localResult gs-result">';

  finalHTML = finalHTML + '<div class="gs-title"><a target="_blank" class="gs-title" href="' + url + '">' + title + '</a></div>';

  finalHTML = finalHTML + '<div class="gs-address">';

  finalHTML = finalHTML + '<div class="gs-street gs-addressLine">' + address1 + '</div>';

  if (address2 !== null) {

    finalHTML = finalHTML + '<div class="gs-city gs-addressLine">' + address2 + '</div>';

  }

  finalHTML = finalHTML + '</div>';

  finalHTML = finalHTML + '<div class="gs-phone">Phone: ' + phone + '</div>';

  finalHTML = finalHTML + "<div class='gs-streetview'><a class='gs-sv-link' onclick='showStreetView(" + onClickSVCode + ")' style='cursor: pointer'>Street View</a><a class='gs-dd-link' onclick='showDirections(" + onClickDDCode + ")' style='cursor: pointer'>Directions</a></div>";

  finalHTML = finalHTML + '</div>';

  return finalHTML;

}

function createXmlHTML(address, title, html, url, lat, lng) {

  var onClickSVCode = '"' + lat + '","' + lng + '","' + address + '"';

  var onClickDDCode = '"' + address + '"';

  var finalHTML;

  finalHTML = '<div class="gs-localResult gs-result">';

  finalHTML = finalHTML + '<div class="gs-title"><a target="_blank" class="gs-title" href="' + url + '">' + title + '</a></div>';

  finalHTML = finalHTML + '<div class="gs-customHTML">' + html;

  finalHTML = finalHTML + '</div>';

//  finalHTML = finalHTML + "<div class='gs-streetview'><a class='gs-sv-link' onclick='showStreetView(" + onClickSVCode + ")' style='cursor: pointer'>Street View</a></div>";

    finalHTML = finalHTML + "<div class='gs-streetview'><a class='gs-sv-link' onclick='showStreetView(" + onClickSVCode + ")' style='cursor: pointer'>Street View</a><a class='gs-dd-link' onclick='showDirections(" + onClickDDCode + ")' style='cursor: pointer'>Directions</a></div>";

  finalHTML = finalHTML + '</div>';

  return finalHTML;

}

function CreateHTMLList(address, title, html, url) {

  var ListHTML;

  ListHTML = '<div style="border: 1px solid #996600; margin: 5px; width: 630px; font-family:\'Lucida Sans\', \'Lucida Sans Regular\', \'Lucida Grande\', \'Lucida Sans Unicode\', Geneva, Verdana, sans-serif; font-size:12px; ">';

	ListHTML = ListHTML + '<div style="float:left;width: 200px; height: 100px; padding:5px">';

	ListHTML = ListHTML + '</div>';

	ListHTML = ListHTML + '<div style="width: 400px; float:right; padding:5px">';

 	ListHTML = ListHTML + '   <div style="padding:5px; background-color: #F8F0E9;">';

	ListHTML = ListHTML + '	   <strong>' + title + '</strong></div>';

	ListHTML = ListHTML + '	<div style="padding:5px; color: #7B7B7B;">';

	ListHTML = ListHTML + '	' + html + '</div>';

	ListHTML = ListHTML + '	<div style="padding:5px">';

  	ListHTML = ListHTML + '	  Social Media</div>';

  	ListHTML = ListHTML + '	  <div style="padding:5px">';

  	ListHTML = ListHTML + '	  <div style="padding:5px">';

	ListHTML = ListHTML + '  		<div style="width: 280px; float:left">';

	ListHTML = ListHTML + '		    message</div>';

	ListHTML = ListHTML + '		    <div style="width: 81px; float:right">';

	ListHTML = ListHTML + '		    sa';

	ListHTML = ListHTML + '   </div>';

	ListHTML = ListHTML + '  </div>';

	ListHTML = ListHTML + '  </div>';

	ListHTML = ListHTML + '</div>';

	ListHTML = ListHTML + '</div>';

	

	document.getElementById('insta-list').innerHTML = ListHTML;

  return ListHTML;

}

function createXmlHttpRequest() {

 try {

   if (typeof ActiveXObject != 'undefined') {

     return new ActiveXObject('Microsoft.XMLHTTP');

   } else if (window["XMLHttpRequest"]) {

     return new XMLHttpRequest();

   }

 } catch (e) {

   changeStatus(e);

 }

 return null;

};

function downloadUrl(url, callback) {

 var status = -1;

 var request = createXmlHttpRequest();

 if (!request) {

   return false;

 }

 request.onreadystatechange = function() {

   if (request.readyState == 4) {

     try {

       status = request.status;

     } catch (e) {

       // Usually indicates request timed out in FF.

     }

     if (status == 200) {

       callback(request.responseXML, request.status);

       request.onreadystatechange = function() {};

     }

   }

 }

 request.open('GET', url, true);

 try {

   request.send(null);

 } catch (e) {

   changeStatus(e);

 }

};

function xmlParse(str) {

  if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {

    var doc = new ActiveXObject('Microsoft.XMLDOM');

    doc.loadXML(str);

    return doc;

  }

  if (typeof DOMParser != 'undefined') {

    return (new DOMParser()).parseFromString(str, 'text/xml');

  }

  return createElement('div', null);

}

function downloadScript(url) {

  var script = document.createElement('script');

  script.src = url;

  document.body.appendChild(script);

}

/* To Do */

function doSearch(keyword, type) {

  currentCategory = type;

  var icon;

  

  		if (markerGroups[type]) {

		for (var i = 0; i < markerGroups[type].length; i++) {

		  markerGroups[type][i].setMap(null);

		}

		markerGroups[type].length = 0;

		}

  if (keyword.substr(0,3) == "db:"){ 

  var bounds = map.getBounds();

  var southWest = bounds.getSouthWest();

  var northEast = bounds.getNorthEast();

  var swLat = southWest.lat();

  var swLng = southWest.lng();

  var neLat = northEast.lat();

  var neLng = northEast.lng();

  var dbCat = keyword.substr(3);

  

  var filename = dbPath + "db.php?cat="+ dbCat + "&swLat="+ swLat + "&swLng="+ swLng + "&neLat="+ neLat + "&neLng="+ neLng + "&extendLat="+ extendLat + "&extendLng="+ extendLng;

	downloadUrl(filename, function (data) {

    var markers = data.documentElement.getElementsByTagName("marker");

    var hider = document.getElementById(type).getAttribute("caption");

    if (hider != "hidden") {

	if (markers.length !== 0) {

      for (var xmlItem = 0; xmlItem < markers.length; xmlItem++) {

		if (markers[xmlItem].getAttribute("icon") == "" ) {

				icon = type;

			} else {

				icon = markers[xmlItem].getAttribute("icon");

			}

        var xmlHTML = createXmlHTML(markers[xmlItem].getAttribute("address"), markers[xmlItem].getAttribute("title"), markers[xmlItem].getAttribute("html"), markers[xmlItem].getAttribute("url"), markers[xmlItem].getAttribute("lat"), markers[xmlItem].getAttribute("lng"));

		var latlng = new google.maps.LatLng(parseFloat(markers[xmlItem].getAttribute("lat")), parseFloat(markers[xmlItem].getAttribute("lng")));

		createMarker(latlng, xmlItem, xmlHTML, type, icon);

		CreateHTMLList(markers[xmlItem].getAttribute("address"), markers[xmlItem].getAttribute("title"), markers[xmlItem].getAttribute("html"), markers[xmlItem].getAttribute("url"));

      }

    }

  }

      mapLoading.style.display = "none";

});

  

  } else {

	  

  var phoneNumber;

  var searchControl = new google.search.SearchControl();

  var localSearch = new google.search.LocalSearch();

  var options = new google.search.SearcherOptions();

  options.setExpandMode(GSearchControl.EXPAND_MODE_OPEN);

  searchControl.addSearcher(localSearch, options);

  searchControl.setResultSetSize(google.search.Search.LARGE_RESULTSET);

  searchControl.draw(document.getElementById("searchcontrol"));

  searchControl.setSearchCompleteCallback(localSearch, function () {

    var resultcontent = '';

    var results = localSearch.results; // Grab the results array

    var hider = document.getElementById(type).getAttribute("caption");

    if (hider != "hidden") {

      if (results.length !== 0) {

        for (var i = 0; i < results.length; i++) {

          var result = results[i];

		    if (typeof result.phoneNumbers != 'undefined') {

				phoneNumber = result.phoneNumbers[0].number;

			  } else {

				phoneNumber = "";

			  }

          var latlng = new google.maps.LatLng(parseFloat(result.lat), parseFloat(result.lng));

          var resultHTML = createHTML(result.titleNoFormatting, result.url, result.addressLines[0], result.addressLines[1], result.visibleUrl, phoneNumber, result.lat, result.lng);

          createMarker(latlng, i, resultHTML, type);

          if (hider == "hidden") {

            markerGroups[type][i].hide();

          }

        }

      }

    }

    mapLoading.style.display = "none";

  });

  if (addressSet != 1) {

    localSearch.setCenterPoint(startAddress);

  } else {

    localSearch.setCenterPoint(map.getCenter());

  }

  searchControl.execute(keyword);

  }

  return 1;

}

function hasClass(ele, cls) {

  return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));

}

function addClass(ele, cls) {

  if (!this.hasClass(ele, cls)) {

	  ele.className += " " + cls;

  }

}

function removeClass(ele, cls) {

  if (hasClass(ele, cls)) {

    var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');

    ele.className = ele.className.replace(reg, ' ');

  }

}

function toggleGroup(type) {

  classAdder = document.getElementById(type);

  if (markerGroups[type].length !== 0) {

    for (var i = 0; i < markerGroups[type].length; i++) {

      var marker = markerGroups[type][i];

      if (marker.getVisible() === false) {

        classAdder.attributes.getNamedItem("caption").value = "";

        addClass(classAdder, "visibleLayer");

        marker.setVisible(true);

      } else {

        classAdder.attributes.getNamedItem("caption").value = "hidden";

        removeClass(classAdder, "visibleLayer");

        marker.setVisible(false);

      }

    }

  } else {

    mapLoading.style.display = "block";

    doSearch(classAdder.attributes.getNamedItem("title").value, type);

    classAdder.attributes.getNamedItem("caption").value = "";

    addClass(classAdder, "visibleLayer");

  }

}

function handleDDErrors() {

  var ddError = "<h4>Unable to retreive driving directions to this location.</h4><a onclick='closeDirections();' style='text-decoration: underline; cursor: pointer; color: blue'>close</a>";

  var ddErrorDiv = document.createElement('div');

  ddErrorDiv.setAttribute('id', 'ddError');

  ddBoxDiv.appendChild(ddErrorDiv);

  ddErrorDiv.innerHTML = ddError;

  ddErrorDiv.style.width = "50%";

  ddErrorDiv.style.marginLeft = "10%";

}

function closeDirections() {

  mapDiv.removeChild(document.getElementById("ddFrame"));

}

function showDirections(toAddress) {

  var ddFrame = document.createElement('div');

  ddFrame.setAttribute('id', 'ddFrame');

  mapDiv.appendChild(ddFrame);

  centerBox("ddFrame", "map");

  ddBoxDiv = document.createElement('div');

  ddBoxDiv.setAttribute('id', 'ddBox');

  ddFrame.appendChild(ddBoxDiv);

  ddBoxDiv.style.position = "absolute";

  ddBoxDiv.style.left = "5px";

  var ddBoxClose = document.createElement('a');

  ddBoxClose.setAttribute('id', 'ddBoxClose');

  ddFrame.appendChild(ddBoxClose);

  ddBoxClose.style.position = "absolute";

  ddBoxClose.style.zIndex = "10";

  ddBoxClose.style.top = "0px";

  ddBoxClose.style.left = (ddFrame.offsetWidth - ddBoxClose.offsetWidth - 4) + "px";

  ddBoxClose.onclick = function() { 

    closeDirections();

  };

  var ddBoxPrint = document.createElement('a');

  ddBoxPrint.setAttribute('id', 'ddBoxPrint');

  ddFrame.appendChild(ddBoxPrint);

  ddBoxPrint.innerHTML = "<span>Print</span>";

  ddBoxPrint.style.position = "absolute";

  ddBoxPrint.style.zIndex = "10";

  ddBoxPrint.style.top = "4px";

  ddBoxPrint.style.left = (ddFrame.offsetWidth - ddBoxClose.offsetWidth - 29) + "px";

  ddBoxPrint.setAttribute("href", "print/print.html?start=" + escape(startAddress) + "&end=" + escape(toAddress));

  ddBoxPrint.setAttribute("target", "_blank");

  

  directionsService = new google.maps.DirectionsService();

  directionsDisplay = new google.maps.DirectionsRenderer();

  directionsDisplay.setMap(map);

  directionsDisplay.setPanel(ddBoxDiv);

  var travMode;

  var loadStr = "from: " + startAddress + " to: " + toAddress;

  if (directionsMode == 'DRIVING') {

	  travMode = google.maps.DirectionsTravelMode.DRIVING;

  } else {

	  travMode = google.maps.DirectionsTravelMode.WALKING;  }

    var request = {

        origin: startAddress, 

        destination: toAddress,

        travelMode: travMode

    };

    directionsService.route(request, function(response, status) {

      if (status == google.maps.DirectionsStatus.OK) {

        directionsDisplay.setDirections(response);

		return false;

      } else {

		handleDDErrors();  

		return false;

	  }

    });

}

function closeStreetView() {

  mapDiv.removeChild(document.getElementById("svFrame"));

}

function showStreetView(lat, lng, address1, address2) {

  var svFrame = document.createElement('div');

  svFrame.setAttribute('id', 'svFrame');

  mapDiv.appendChild(svFrame);

  centerBox("svFrame", "map");

  var svBoxDiv = document.createElement('div');

  svBoxDiv.setAttribute('id', 'svBox');

  svFrame.appendChild(svBoxDiv);

  svBoxDiv.style.position = "absolute";

  var svBoxClose = document.createElement('a');

  svBoxClose.setAttribute('id', 'svBoxClose');

  svFrame.appendChild(svBoxClose);

  svBoxClose.style.position = "absolute";

  svBoxClose.style.zIndex = "10";

  svBoxClose.style.top = "0px";

  svBoxClose.style.left = (svFrame.offsetWidth - svBoxClose.offsetWidth - 5) + "px";

  svBoxClose.onclick = function() { 

    closeStreetView();

  };

  var svLatLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));

	var panoramaOptions = {

		position: svLatLng

	};

	var panorama = new  google.maps.StreetViewPanorama(document.getElementById("svBox"), panoramaOptions);

	map.setStreetView(panorama);

}

function toggleOverlay(layerState, layer, control) {

  if (overlayControls === true) {	

	  var toggleControl = document.getElementById(control);

	  if (layerState == "off") {

		if (layer.isHidden() === true) {

		  layer.show();

		} else {

		  map.addOverlay(layer);

		}

		toggleControl.style.backgroundColor = "#fc9";

		toggleControl.onclick = function() { toggleOverlay('on', layer , control );};

	  }

	  if (layerState == "on") {

		layer.hide();

		toggleControl.style.backgroundColor = "#fff";

		toggleControl.onclick = function() { toggleOverlay('off', layer , control );};

	  }

  }

}

function getCategories(initial) {

  var i;

  mapLoading.style.display = "block";

  var elem = document.getElementById(categoriesList);

  for (i = 0; i < elem.childNodes.length; i++) {

    if (elem.childNodes[i].nodeName == "LI") {

		var catType = elem.childNodes[i].attributes.getNamedItem("id").value;

		

      result = doSearch(elem.childNodes[i].attributes.getNamedItem("title").value, elem.childNodes[i].attributes.getNamedItem("id").value);

    }

  }

  if (initial == 1) {

  jsonGroups = "";

  jsonGroups = '{ xml: [], "pin": [] ';

  for (i = 0; i < elem.childNodes.length; i++) {

    if (elem.childNodes[i].nodeName == "LI") {

      jsonGroups = jsonGroups + ',  "' + elem.childNodes[i].attributes.getNamedItem("id").value + '": [] ';

    }

  }

  jsonGroups = jsonGroups + "}";

  markerGroups = eval('(' + jsonGroups + ')');

for (i = 0; i < elem.childNodes.length; i++) {

      if (elem.childNodes[i].nodeName == "LI") {

        var elemID = elem.childNodes[i].attributes.getNamedItem("id").value;

        if (elemID != "user") {

          elem.childNodes[i].innerHTML = "<a onclick='" + 'toggleGroup("' + elemID + '")' + "'>" + elem.childNodes[i].innerHTML + "</a>";

        } else {

          elem.childNodes[i].innerHTML = '<form id="userPOIForm" action="#" onsubmit="userPOIFind(this.userPOI.value); return false"><input id="userPOITxt" size="20" name="userPOI" value="' + elem.childNodes[i].innerHTML + '" type="text"><input id="userPOIButton" value="Go" type="submit"> </form>';

        }

        if (hasClass(elem.childNodes[i], "hidden") !== null) {

          elem.childNodes[i].setAttribute("caption", "hidden");

        } else {

          elem.childNodes[i].setAttribute("caption", "");

        }

        if (elem.childNodes[i].attributes.getNamedItem("caption").value != "hidden") {

          classAdder = document.getElementById(elemID);

          addClass(classAdder, "visibleLayer");

        }

      }

    }

  }

  if (typeof xmlFile === 'undefined') {

    // Do Nothing for now

  } else {

    addXML(xmlFile);

  }

}

function userPOIFind(searchText) {

  document.getElementById("user").setAttribute("title", searchText);

  getCategories(0);

}

function findAddress(address, HTML) {

  if (HTML === undefined) {

    HTML = "<strong>" + address + "</strong>";

  }

  markerHTML = HTML;

  

  	var geocoder = new google.maps.Geocoder();

    geocoder.geocode( { 'address': address}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {

        map.setCenter(results[0].geometry.location);

   		addressSet = 1;

		startAddress = address;

		searchCenter = results[0].geometry.location;

		createMarker(searchCenter, 0, markerHTML, "pin");

		var trafficLayer = new google.maps.TrafficLayer();

		trafficLayer.setMap(map);

		    getCategories(0);

		if (mapExtra === true) {

			mapPost();

		}

	} else {

        alert("Geocode was not successful for the following reason: " + status);

      }

    });

	

}

function OnLoad() {

	setupAddress();

	mapDiv = document.getElementById(mapDivID);

	var myLatlng = new google.maps.LatLng(0,0);

	var myOptions = {

		zoom: zoomLevel,

		scrollwheel: true,

		disableDoubleClickZoom: true,

		center: myLatlng,

		mapTypeControl: true,

		mapTypeControlOptions: {

		  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU

		},

		zoomControl: true,

		zoomControlOptions: {

		  style: google.maps.ZoomControlStyle.SMALL

		},

		panControl: false,

		mapTypeId: google.maps.MapTypeId.ROADMAP

	}

	map = new google.maps.Map(mapDiv, myOptions);

	infoBox();

	var geocoder = new google.maps.Geocoder();

    var address = startAddress;

    geocoder.geocode( { 'address': address}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {

        map.setCenter(results[0].geometry.location);

   		addressSet = 1;

		searchCenter = results[0].geometry.location;

        getCategories(1);

		createMarker(searchCenter, 0, markerHTML, "pin");

		var trafficLayer = new google.maps.TrafficLayer();

		trafficLayer.setMap(map);

	    google.maps.event.addListener(map, "dragend", function () {

			       getCategories(0);

	    });

		if (mapExtra === true) {

			mapPost();

		}

		} else {

        alert("Geocode was not successful for the following reason: " + status);

      }

    });

}

google.setOnLoadCallback(OnLoad);