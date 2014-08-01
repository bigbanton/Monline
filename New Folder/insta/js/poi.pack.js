var J = null,

N = "",

r = false,

T = 'DRIVING',

Q = "map",

qf = false,

q = true;

google.load("search", "1");

var defaultAddress = "New York, USA",

defaultHTML = "<strong>New York,<br/> USA</strong>",

defaultZoomLevel = 15,

infoHTML = "<h4>Instructions</h4><p>Drag the map or enter an address above to view a different area's information. Click on the list of categories to show points of interest on the map. Click on each point to see more detail.</p>",

searchControls = q,

mapDivID = Q,

categoriesList = "poiList",

directionsMode = T,

extendLat = 0.05,

extendLng = 0.005,

mainIconWidth = 43,

mainIconHeight = 50,

mainAnchorPointX = 17,

mainAnchorPointY = 49,

iconPath = "icons/",

iconWidth = 32,

iconHeight = 37,

anchorPointX = 16,

anchorPointY = 34,

dbPath = "db/",

xmlExtra = r,

mapExtra = r,

classAdder, markerGroups = N,

map = J,

searchCenter, addressSet, overlayControls, wikiLayer, photoLayer, startAddress, directions, myPano, jsonGroups, mapDiv, mapLoading, ddBoxDiv, batchGeoLat = [],

batchGeoLng = [],

lastInfoWindow,

directionDisplay,

directionsService;

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

function centerBox(t, h) {

	var W = document.getElementById(t).offsetHeight,

	e = Math.round(parseInt(document.getElementById(h).offsetHeight, 10) / 2),

	a = Math.round(W / 2),

	v = (e - a) + "px";

	document.getElementById(t).style.top = v;

	var H = document.getElementById(t).offsetWidth,

	$ = Math.round(parseInt(document.getElementById(h).offsetWidth, 10) / 2),

	Z = Math.round(H / 2),

	f = $ - Z;

	document.getElementById(t).style.left = f + "px";

}

function hideInfoBox() {

	document.getElementById("infoBox").style.display = "none";

}

function infoBox() {

	mapLoading = document.createElement('div');

	mapLoading.style.zIndex = 10;

	mapLoading.setAttribute('id', 'mapLoading');

	mapDiv.appendChild(mapLoading);

	centerBox("mapLoading", Q);

	if (infoHTML != N) {

		var t = document.createElement('div');

		t.setAttribute('id', 'infoBox');

		mapDiv.appendChild(t);

		t.innerHTML = infoHTML;

		t.style.position = "absolute";

		t.style.zIndex = "1";

		t.style.top = (mapDiv.offsetHeight - t.offsetHeight) + "px";

		var h = document.createElement('a');

		h.setAttribute('id', 'infoBoxClose');

		t.appendChild(h);

		h.style.position = "absolute";

		h.style.top = "4px";

		h.style.left = "4px";

		h.onclick = function () {

			hideInfoBox();

		};

	}

	var W = document.createElement('div');

	W.setAttribute('id', 'overlayControl');

	mapDiv.appendChild(W);

	W.style.position = "absolute";

	W.style.zIndex = 2;

	var e = N;

	if (searchControls === q) {

		var qs = querySt("address");

		if (qs != '' && typeof(qs) != null && typeof(qs) != 'undefined') {

			qs = decodeURIComponent(qs);

		} else {

			qs = "Enter a City or Address";

		}

		e = e + '<form id="searchForm" action="#" onsubmit="findAddress(this.address.value); return false">';

		e = e + '<input id="searchTxt" type="text" size="20" name="address" value="' + qs + '" />';

		e = e + '<input id="searchButton" type="submit" value="Go" /> </form>';

	}

	W.innerHTML = e;

}

function querySt(ji) {

	hu = window.location.search.substring(1);

	gy = hu.split("&");

	for (i=0;i<gy.length;i++) {

		ft = gy[i].split("=");

		if (ft[0] == ji) {

			return ft[1];

		}

	}

}

function createMarker(v, H, $, Z, f, address, listhtml) {

	var L = "-shadow.png",

	d;

	if (f === undefined) {

		f = Z;

	}

	if (Z == "pin") {

		if (markerGroups["pin"]) {

			for (var b = 0; b < markerGroups["pin"].length; b++) {

				markerGroups["pin"][b].setMap(J);

			}

			markerGroups["pin"].length = 0;

		}

		var Y = new google.maps.MarkerImage(iconPath + Z + ".png", new google.maps.Size(mainIconWidth, mainIconHeight), new google.maps.Point(0, 0), new google.maps.Point(mainAnchorPointX, mainAnchorPointY)),

		R = new google.maps.MarkerImage(iconPath + Z + L, new google.maps.Size(mainIconWidth, mainIconHeight), new google.maps.Point(0, 0), new google.maps.Point(mainAnchorPointX, mainAnchorPointY)),

		c = new google.maps.Marker({

			position: v,

			map: map,

			shadow: R,

			icon: Y

		});

		markerGroups["pin"].push(c);

		var I = new google.maps.InfoWindow({

			content: $

		});

		google.maps.event.addListener(c, 'click', function () {

			I.open(map, c);

		});

		document.getElementById('insta-list').innerHTML='';

	} else {

		if (f == N) {

			f = Z;

		}

		var Y = new google.maps.MarkerImage(iconPath + f + ".png", new google.maps.Size(iconWidth, iconHeight), new google.maps.Point(0, 0), new google.maps.Point(anchorPointX, anchorPointY)),

		R = new google.maps.MarkerImage(iconPath + f + L, new google.maps.Size(iconWidth, iconHeight), new google.maps.Point(0, 0), new google.maps.Point(anchorPointX, anchorPointY));

			CreateHTMLList(address,listhtml);

	}

	if (Z == "xml") {} else {

		var c = new google.maps.Marker({

			position: v,

			map: map,

			shadow: R,

			icon: Y,

			title: Z

		});

		markerGroups[Z].push(c);

		var I = new google.maps.InfoWindow({

			content: $

		});

		google.maps.event.addListener(c, 'click', function () {

			if (lastInfoWindow) lastInfoWindow.close();

			I.open(map, c);

			lastInfoWindow = I;

		});

	}

}

function createHTML(t, h, W, e, a, v, H, $) {

	var Z = '"' + H + '","' + $ + '","' + W + '","' + e + '"',

	f = '"' + W + ' ' + e + '"',

	L;

	L = '<div class="gs-localResult gs-result">';

	L = L + '<div class="gs-title"><a target="_blank" class="gs-title" href="' + h + '">' + t + '</a></div>';

	L = L + '<div class="gs-address">';

	L = L + '<div class="gs-street gs-addressLine">' + W + '</div>';

	if (e !== J) {

		L = L + '<div class="gs-city gs-addressLine">' + e + '</div>';

	}

	L = L + '</div>';

	L = L + '<div class="gs-phone">Phone: ' + v + '</div>';

	L = L + "<div class='gs-streetview'><a class='gs-sv-link' onclick='showStreetView(" + Z + ")' style='cursor: pointer'>Street View</a><a class='gs-dd-link' onclick='showDirections(" + f + ")' style='cursor: pointer'>Directions</a></div>";

	L = L + '</div>';

	return L;

}

function createXmlHTML(t, h, W, e, a, v) {

	var H = '"' + a + '","' + v + '","' + t + '"',

	$ = '"' + t + '"',

	Z;

	Z = '<div class="gs-localResult gs-result">';

	Z = Z + '<div class="gs-title"><a target="_blank" class="gs-title" href="' + e + '">' + h + '</a></div>';

	Z = Z + '<div class="gs-customHTML">' + W;

	Z = Z + '</div>';

	Z = Z + "<div class='gs-streetview'><a class='gs-sv-link' onclick='showStreetView(" + H + ")' style='cursor: pointer'>Street View</a><a class='gs-dd-link' onclick='showDirections(" + $ + ")' style='cursor: pointer'>Directions</a></div>";

	Z = Z + '</div>';

	return Z;

}

function CreateHTMLList(address, html) {

	var ListHTML;

	ListHTML='';

	if (html !== ""){

		ListHTML = html;

		

		var newcontent = document.createElement('div');

		newcontent.innerHTML = ListHTML;

		while (newcontent.firstChild) {

			document.getElementById('insta-list').appendChild(newcontent.firstChild);

		}

	}

  return ListHTML;

}

function createXmlHttpRequest() {

	try {

		if (typeof ActiveXObject != 'undefined') {

			return new ActiveXObject('Microsoft.XMLHTTP');

		} else if (window["XMLHttpRequest"]) {

			return new XMLHttpRequest();

		}

	} catch(t) {

		changeStatus(t);

	}

	return J;

};

function downloadUrl(h, W) {

	var e = -1,

	a = createXmlHttpRequest();

	if (!a) {

		return r;

	}

	a.onreadystatechange = function () {

		if (a.readyState == 4) {

			try {

				e = a.status;

			} catch(t) {}

			if (e == 200) {

				W(a.responseXML, a.status);

				a.onreadystatechange = function () {};

			}

		}

	};

	a.open('GET', h, q);

	try {

		a.send(J);

	} catch(t) {

		changeStatus(t);

	}

};

function xmlParse(t) {

	if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {

		var h = new ActiveXObject('Microsoft.XMLDOM');

		h.loadXML(t);

		return h;

	}

	if (typeof DOMParser != 'undefined') {

		return (new DOMParser()).parseFromString(t, 'text/xml');

	}

	return createElement('div', J);

}

function downloadScript(t) {

	var h = document.createElement('script');

	h.src = t;

	document.body.appendChild(h);

}

function doSearch($, Z) {

	document.getElementById('insta-list').innerHTML='';

	currentCategory = Z;

	var f;

	if (markerGroups[Z]) {

		for (var L = 0; L < markerGroups[Z].length; L++) {

			markerGroups[Z][L].setMap(J);

		}

		markerGroups[Z].length = 0;

	}

	if ($.substr(0, 3) == "db:") {

		var d = map.getBounds(),

		b = d.getSouthWest(),

		Y = d.getNorthEast(),

		R = b.lat(),

		c = b.lng(),

		I = Y.lat(),

		C = Y.lng(),

		B = $.substr(3),

		F = dbPath + "db.php?cat=" + B + "&swLat=" + R + "&swLng=" + c + "&neLat=" + I + "&neLng=" + C + "&extendLat=" + extendLat + "&extendLng=" + extendLng;

		//window.location=F;

		downloadUrl(F, function (t) {

			var h = t.documentElement.getElementsByTagName("marker"),

			W = document.getElementById(Z).getAttribute("caption");

			if (W != "hidden") {

				if (h.length !== 0) {

					for (var e = 0; e < h.length; e++) {

						if (h[e].getAttribute("icon") == N) {

							f = Z;

						} else {

							f = h[e].getAttribute("icon");

						}

						var a = createXmlHTML(h[e].getAttribute("address"), h[e].getAttribute("title"), h[e].getAttribute("html"), h[e].getAttribute("url"), h[e].getAttribute("lat"), h[e].getAttribute("lng")),

						v = new google.maps.LatLng(parseFloat(h[e].getAttribute("lat")), parseFloat(h[e].getAttribute("lng")));

						createMarker(v, e, a, Z, f,h[e].getAttribute("listhtml"),h[e].getAttribute("listhtml"));

						//CreateHTMLList(h[e].getAttribute("address"), h[e].getAttribute("listhtml"));

					}

				}

			}

			mapLoading.style.display = "none";

		});

	} else {

		var g, M = new google.search.SearchControl(),

		_ = new google.search.LocalSearch(),

		S = new google.search.SearcherOptions();

		S.setExpandMode(GSearchControl.EXPAND_MODE_OPEN);

		M.addSearcher(_, S);

		M.setResultSetSize(google.search.Search.LARGE_RESULTSET);

		M.draw(document.getElementById("searchcontrol"));

		M.setSearchCompleteCallback(_, function () {

			var t = '',

			h = _.results,

			W = document.getElementById(Z).getAttribute("caption");

			if (W != "hidden") {

				if (h.length !== 0) {

					for (var e = 0; e < h.length; e++) {

						var a = h[e];

						if (typeof a.phoneNumbers != 'undefined') {

							g = a.phoneNumbers[0].number;

						} else {

							g = N;

						}

						var v = new google.maps.LatLng(parseFloat(a.lat), parseFloat(a.lng)),

						H = createHTML(a.titleNoFormatting, a.url, a.addressLines[0], a.addressLines[1], a.visibleUrl, g, a.lat, a.lng);

						createMarker(v, e, H, Z);

						if (W == "hidden") {

							markerGroups[Z][e].hide();

						}

					}

				}

			}

			mapLoading.style.display = "none";

		});

		if (addressSet != 1) {

			_.setCenterPoint(startAddress);

		} else {

			_.setCenterPoint(map.getCenter());

		}

		M.execute($);

	}

	return 1;

}

function hasClass(t, h) {

	return t.className.match(new RegExp('(\\s|^)' + h + '(\\s|$)'));

}

function addClass(t, h) {

	if (!this.hasClass(t, h)) {

		t.className += " " + h;

	}

}

function removeClass(t, h) {

	if (hasClass(t, h)) {

		var W = new RegExp('(\\s|^)' + h + '(\\s|$)');

		t.className = t.className.replace(W, ' ');

	}

}

function getElementsByClass( searchClass, domNode, tagName) { 

	if (domNode == null) domNode = document;

	if (tagName == null) tagName = '*';

	var el = new Array();

	var tags = domNode.getElementsByTagName(tagName);

	var tcl = " "+searchClass+" ";

	for(i=0,j=0; i<tags.length; i++) { 

		var test = " " + tags[i].className + " ";

		if (test.indexOf(tcl) != -1) 

			el[j++] = tags[i];

	} 

	return el;

}

function toggleClassGroup(t,v,n,g) {

	var classListAdd = getElementsByClass(t, n, g);

	var newDisplay;

	newDisplay = v;

				for(var i = 0; i < classListAdd.length; i++)

				{

					classListAdd[i].style.display = newDisplay;

				}

}

function toggleGroup(t) {

	classAdder = document.getElementById(t);

	

	if (markerGroups[t].length !== 0) {

		for (var h = 0; h < markerGroups[t].length; h++) {

			var W = markerGroups[t][h];

			if (W.getVisible() === r) {

				classAdder.attributes.getNamedItem("caption").value = N;

				addClass(classAdder, "visibleLayer");

				W.setVisible(q);

				toggleClassGroup(t+'list','block',null,"div");				

			} else {

				classAdder.attributes.getNamedItem("caption").value = "hidden";

				removeClass(classAdder, "visibleLayer");

				W.setVisible(r);

				toggleClassGroup(t+'list','none',null,"div");

			}

		}

	} else {

		mapLoading.style.display = "block";

		doSearch(classAdder.attributes.getNamedItem("title").value, t);

		classAdder.attributes.getNamedItem("caption").value = N;

		addClass(classAdder, "visibleLayer");

	}

}

function handleDDErrors() {

	var t = "<h4>Unable to retreive driving directions to this location.</h4><a onclick='closeDirections();' style='text-decoration: underline; cursor: pointer; color: blue'>close</a>",

	h = document.createElement('div');

	h.setAttribute('id', 'ddError');

	ddBoxDiv.appendChild(h);

	h.innerHTML = t;

	h.style.width = "50%";

	h.style.marginLeft = "10%";

}

function closeDirections() {

	mapDiv.removeChild(document.getElementById("ddFrame"));

}

function showDirections(e) {

	var a = document.createElement('div');

	a.setAttribute('id', 'ddFrame');

	mapDiv.appendChild(a);

	centerBox("ddFrame", Q);

	ddBoxDiv = document.createElement('div');

	ddBoxDiv.setAttribute('id', 'ddBox');

	a.appendChild(ddBoxDiv);

	ddBoxDiv.style.position = "absolute";

	ddBoxDiv.style.left = "5px";

	var v = document.createElement('a');

	v.setAttribute('id', 'ddBoxClose');

	a.appendChild(v);

	v.style.position = "absolute";

	v.style.zIndex = "10";

	v.style.top = "0px";

	v.style.left = (a.offsetWidth - v.offsetWidth - 4) + "px";

	v.onclick = function () {

		closeDirections();

	};

	var H = document.createElement('a');

	H.setAttribute('id', 'ddBoxPrint');

	a.appendChild(H);

	H.innerHTML = "<span>Print</span>";

	H.style.position = "absolute";

	H.style.zIndex = "10";

	H.style.top = "4px";

	H.style.left = (a.offsetWidth - v.offsetWidth - 29) + "px";

	H.setAttribute("href", "print/print.html?start=" + escape(startAddress) + "&end=" + escape(e));

	H.setAttribute("target", "_blank");

	directionsService = new google.maps.DirectionsService();

	directionsDisplay = new google.maps.DirectionsRenderer();

	directionsDisplay.setMap(map);

	directionsDisplay.setPanel(ddBoxDiv);

	var $, Z = "from: " + startAddress + " to: " + e;

	if (directionsMode == 'WALKING') {

		$ = google.maps.DirectionsTravelMode.WALKING;

	} else {

		$ = google.maps.DirectionsTravelMode.DRIVING;

	}

	var f = {

		origin: startAddress,

		destination: e,

		travelMode: $

	};

	directionsService.route(f, function (t, h) {

		if (h == google.maps.DirectionsStatus.OK) {

			directionsDisplay.setDirections(t);

			return r;

		} else {

			handleDDErrors();

			return r;

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

function toggleOverlay(t, h, W) {

	if (overlayControls === q) {

		var e = document.getElementById(W);

		if (t == "off") {

			if (h.isHidden() === q) {

				h.show();

			} else {

				map.addOverlay(h);

			}

			e.style.backgroundColor = "#fc9";

			e.onclick = function () {

				toggleOverlay('on', h, W);

			};

		}

		if (t == "on") {

			h.hide();

			e.style.backgroundColor = "#fff";

			e.onclick = function () {

				toggleOverlay('off', h, W);

			};

		}

	}

}

function getCategories(t) {

	var h = "id",

	W;

	mapLoading.style.display = "block";

	var e = document.getElementById(categoriesList);

	for (W = 0; W < e.childNodes.length; W++) {

		if (e.childNodes[W].nodeName == "LI") {

			var a = e.childNodes[W].attributes.getNamedItem(h).value;

			result = doSearch(e.childNodes[W].attributes.getNamedItem("title").value, e.childNodes[W].attributes.getNamedItem(h).value);

		}

	}

	if (t == 1) {

		jsonGroups = N;

		jsonGroups = '{ xml: [], "pin": [] ';

		for (W = 0; W < e.childNodes.length; W++) {

			if (e.childNodes[W].nodeName == "LI") {

				jsonGroups = jsonGroups + ',  "' + e.childNodes[W].attributes.getNamedItem(h).value + '": [] ';

			}

		}

		jsonGroups = jsonGroups + "}";

		markerGroups = eval('(' + jsonGroups + ')');

		for (W = 0; W < e.childNodes.length; W++) {

			if (e.childNodes[W].nodeName == "LI") {

				var v = e.childNodes[W].attributes.getNamedItem(h).value;

				if (v != "user") {

					e.childNodes[W].innerHTML = "<a onclick='" + 'toggleGroup("' + v + '")' + "'>" + e.childNodes[W].innerHTML + "</a>";

				} else {

					e.childNodes[W].innerHTML = '<form id="userPOIForm" action="#" onsubmit="userPOIFind(this.userPOI.value); return false"><input id="userPOITxt" size="20" name="userPOI" value="' + e.childNodes[W].innerHTML + '" type="text"><input id="userPOIButton" value="Go" type="submit"> </form>';

				}

				if (hasClass(e.childNodes[W], "hidden") !== J) {

					e.childNodes[W].setAttribute("caption", "hidden");

				} else {

					e.childNodes[W].setAttribute("caption", N);

				}

				if (e.childNodes[W].attributes.getNamedItem("caption").value != "hidden") {

					classAdder = document.getElementById(v);

					addClass(classAdder, "visibleLayer");

				}

			}

		}

	}

	if (typeof xmlFile === 'undefined') {} else {

		addXML(xmlFile);

	}

}

function userPOIFind(t) {

	document.getElementById("user").setAttribute("title", t);

	getCategories(0);

}

function findAddress(e, a) {

	if (a === undefined) {

		a = "<strong>" + e + "</strong>";

	}

	markerHTML = a;

	var v = new google.maps.Geocoder();

	v.geocode({

		'address': e

	},

	function (t, h) {

		if (h == google.maps.GeocoderStatus.OK) {

			map.setCenter(t[0].geometry.location);

			addressSet = 1;

			startAddress = e;

			searchCenter = t[0].geometry.location;

			createMarker(searchCenter, 0, markerHTML, "pin");

			//var W = new google.maps.TrafficLayer();

			//W.setMap(map);

			getCategories(0);

			if (mapExtra === q) {

				mapPost();

			}

		} else {

			alert("Geocode was not successful for the following reason: " + h);

		}

	});

}

function OnLoad() {

	setupAddress();

	mapDiv = document.getElementById(mapDivID);

	var d = new google.maps.LatLng(0, 0),

	b = {

		zoom: zoomLevel,

		scrollwheel: qf,

		disableDoubleClickZoom: q,

		center: d,

		mapTypeControl: q,

		mapTypeControlOptions: {

			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU

		},

		zoomControl: q,

		//zoomControlOptions: {

		//	style: google.maps.ZoomControlStyle.SMALL

		//},

		//panControl: r,

		mapTypeId: google.maps.MapTypeId.ROADMAP

	};

	map = new google.maps.Map(mapDiv, b);

	infoBox();

	var Y = new google.maps.Geocoder(),

	R = startAddress;

	Y.geocode({

		'address': R

	},

	function (t, h) {

		if (h == google.maps.GeocoderStatus.OK) {

			map.setCenter(t[0].geometry.location);

			addressSet = 1;

			searchCenter = t[0].geometry.location;

			getCategories(1);

			createMarker(searchCenter, 0, markerHTML, "pin");

			//var W = new google.maps.TrafficLayer();

			//W.setMap(map);

			google.maps.event.addListener(map, "dragend", function () {

				getCategories(0);

			});

			if (mapExtra === q) {

				mapPost();

			}

		} else {

			alert("Geocode was not successful for the following reason: " + h);

		}

	});

}

google.setOnLoadCallback(OnLoad);