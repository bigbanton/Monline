(function($){

	$.fn.jshare = function(custom) {

var defaults = {

				

				jsharedir			:	'./jshare/',	// Set the directory for the jshare files like style.css & script.js

				

				title				:	'<strong>Share, Bookmark or Email</strong> this page.',

				

				highlight			:	true,		// Highlight share icon on hover?

			

				share				:	'facebook,twitter,digg,print,google_buzz,delicious,stumbleupon,orkut,tumblr,linkedin,myspace,yahoo_buzz,bebo,mixx,friendfeed',	// Enter buttons to show on share tab

				bookmark			:	'favorites,google,yahoo,live,digg,squidoo',	// Enter buttons to show on bookmark tab

				

				iconsdir			:	'./jshare/images/icons/',	//  Default is jsharedir + images/icons/

				imageextension		:	'png',		// Icon image format (jpg, png, gif, etc...)

				

				opentab				:	'share',	// first tab to open when clicked on jshare. share, bookmark or email?

		

				blanktarget			:	true,		// Open links on new tab/window?

				stickybutton		:	true,		// Add the sticky button on the side?

				

				emailform			:	true,		// Disply email form?

			

				shareurl			:	'',			// URL to share (Default is your current page's URL)

				sharetitle			:	'',			// Page title to share (Default is your current page's title)

			

				overlay				:	true,		// cover up the background?

				overlayopacity		:	0.3,

				overlaycolor		:	'#000',

		

				speedin				:	300,		// Set durations of fadein in milliseconds

				speedout			:	300			// Set durations of fadeout in milliseconds

		  };

		  

var settings	= $.extend({}, defaults, custom);

var notie6 = window.XMLHttpRequest; // Stop IE6 from showing jshare badly

if(notie6){

// Add the stylesheet to the head if using jshare

$("head").append("<link />");

$("head").children(":last").attr({

								"rel": "stylesheet",

								"type": "text/css",

								"href": settings.jsharedir + 'style.css'

});

}

var jshare_box = [ // jshare box HTML

				  '<div id="jshare_box">',

				  '<div id="jshare_close" />',

				  '<div id="jshare_content"><div id="share_content">',

				  '<div class="jshare_title">'+settings.title+'</div>',

				  '<div id="jshare_nav">',

				  '<table width="100%" border="0" cellspacing="2"><tr><td><p><a href="javascript:void(0);" id="jshare_share_link" title="Share" class="jshare_tip"><img src="'+settings.jsharedir+'images/share.png" /></a></p></td></tr><tr><td><p><a href="javascript:void(0);" id="jshare_bookmark_link" title="Bookmark" class="jshare_tip"><img src="'+settings.jsharedir+'images/bookmark.png" /></a></p></td></tr><tr><td><p><a href="javascript:void(0);" id="jshare_email_link" title="Email" class="jshare_tip"><img src="'+settings.jsharedir+'images/email.png" /></a></p></td></tr></table>',

				  '</div><div id="jshare_main">', 

				  '<div id="jshare_share" /><div id="jshare_bookmark" /><div id="jshare_email" />',

				  '</div><div style="clear: both"></div></div></div></div>'

				  ];

overlay	= $('<div id="jshare-overlay" class="jshare_close" />');

if(settings.overlay) { // if overlay true, add opacity and colour or set opacity to 0

				overlay.css({'background-color' : settings.overlaycolour, 'opacity' : settings.overlayopacity});

} else {

				overlay.css({'opacity' : '0.0'});

}

if(notie6){

	$('body').append(  // If using sticky button, add these HTMl to body

				jshare_box.join(''), // Join jshare box HTML and display

				overlay // Add overlay

	);

	if(settings.stickybutton){

		var jbutton = $('<a href="javascript:void(0);" id="jshare_button" class="jshare" title="Share and Bookmark this page"><img src="' + settings.jsharedir + 'images/jbutton.png" border="0" /></a>');

		$('body').append(jbutton).fadeIn(settings.speedin); // Fade in sticky button if true

	}

}

close_button = $('<a href="javascript:void(0);" class="jshare_close"><img border="0" src="' + settings.jsharedir + 'images/jshare_close.png" alt="close" /></a>').appendTo('#jshare_close');

$('.jshare_close').click(function() {

								  $('#jshare_box').fadeOut(settings.speedout);

								  overlay.fadeOut(settings.speedout);

								  $('#jshare_email').fadeOut();

								  $('#jshare_bookmark').fadeOut();

								  $('#jshare_share').fadeOut();

								  });

if(notie6){

$('.jshare').click(function() { // When jshare class is clicked

							$('#jshare_box').fadeIn(settings.speedin);

							$('#jshare_'+settings.opentab).fadeIn(settings.speedin);

							overlay.fadeIn(settings.speedin);

							});

$('.jshare_share').click(function() { // When jshare class is clicked

								  $('#jshare_box').fadeIn(settings.speedin);

								  $('#jshare_share').fadeIn(settings.speedin);

								  overlay.fadeIn(settings.speedin);

							});

$('.jshare_bookmark').click(function() { // When jshare class is clicked

									 $('#jshare_box').fadeIn(settings.speedin);

									 $('#jshare_bookmark').fadeIn(settings.speedin);

									 overlay.fadeIn(settings.speedin);

							});

$('.jshare_email').click(function() { // When jshare class is clicked

								  $('#jshare_box').fadeIn(settings.speedin);

								  $('#jshare_email').fadeIn(settings.speedin);

								  overlay.fadeIn(settings.speedin);

							});

}

$('#jshare_share_link').click(function() {

									   $('#jshare_email').fadeOut(function(){

																		   $('#jshare_bookmark').fadeOut(function() {

																												  $('#jshare_share').fadeIn(settings.speedin);

																												  });

																		   });

									   });

$('#jshare_bookmark_link').click(function() {

									   $('#jshare_email').fadeOut(function() {

																		   $('#jshare_share').fadeOut(function() {

																											   $('#jshare_bookmark').fadeIn(settings.speedin);

																											   });

																		   });

									   });

$('#jshare_email_link').click(function() {

									   if(settings.emailform){

										   $('#jshare_bookmark').fadeOut(function() {

																				  $('#jshare_share').fadeOut(function() {

																													  $('#jshare_email').fadeIn(settings.speedin);

																													  });

																				  });

										   } else {

											   window.location.href = "mailto:?subject=Check out "+document.title+"&body= You might like "+document.title+".%0D%0A "+document.location.href;

											   }

											   });

var target = settings.blanktarget ? 'target="_blank"' : ''; // If target _blank

		// Get meta keywords

		var jshare_keywords;

		function jshare_metakeywords() { 

			if(jshare_description === undefined){

				metaCollection = document.getElementsByTagName('meta'); 

				for (i=0;i<metaCollection.length;i++) { 

					nameAttribute = metaCollection[i].name.search(/keywords/);

					if (nameAttribute!= -1) { 

						jshare_keywords = metaCollection[i].content;

						return jshare_keywords; 

					} 

				} 

			}else{

				return jshare_keywords;

			}

		} 

		

		// Get meta description

		var jshare_description;

		function jshare_metadescription() { 

			if(jshare_description === undefined){

				metaCollection = document.getElementsByTagName('meta'); 

				for (i=0;i<metaCollection.length;i++) { 

					nameAttribute = metaCollection[i].name.search(/description/);

					if (nameAttribute!= -1) { 

						jshare_description = metaCollection[i].content;

						return jshare_description; 

					} 

				} 

			}else{

				return jshare_description;

			}

		} 

		// Get URL to share

		function jshare_url(){

			if(settings.shareurl) { // if share url is set

				return settings.shareurl;

			} else { 

			return document.location.href;

			}

		}

		

		function jshare_title(){

			if(settings.sharetitle) {

				return settings.sharetitle;

			} else {

				return document.title;

			}

		}

		

		// Encode url

		function encodeURL(string) {

			if(string === undefined){

				return "";

			}

			return string.replace(/\s/g, '%20').replace('+', '%2B').replace('/%20/g', '+').replace('*', '%2A').replace('/', '%2F').replace('@', '%40');

		}

		

		if(settings.emailform){

			$("#jshare_email").load(settings.jsharedir + "email/email_form.php?dir="+settings.jsharedir+"&url="+encodeURL(jshare_url())+"&title="+encodeURL(jshare_title()));

			var mail_link = 'javascript:void(0);" onClick="email_this();" target="_self';

		} else {

			var mail_link = 'mailto:?subject=Check out {TITLE}&body= You might like {TITLE}.%0D%0A {URL} %0D%0A {DESCRIPTION}" target="_self';

			}

		

// Sharing services URL format list

var jformat				=	Array();

jformat.digg			=	"http://digg.com/submit?phase=2&url={URL}&title={TITLE}";

jformat.linkedin		=	"http://www.linkedin.com/shareArticle?mini=true&url={URL}&title={TITLE}&summary={DESCRIPTION}&source=";

jformat.technorati		=	"http://www.technorati.com/faves?add={URL}";

jformat.delicious		=	"http://del.icio.us/post?url={URL}&title={TITLE}";

jformat.yahoo			=	"http://myweb2.search.yahoo.com/myresults/bookmarklet?u={URL}&t={TITLE}";

jformat.google			=	"http://www.google.com/bookmarks/mark?op=edit&bkmk={URL}&title={TITLE}";

jformat.newsvine		=	"http://www.newsvine.com/_wine/save?u={URL}&h={TITLE}";

jformat.reddit			=	"http://reddit.com/submit?url={URL}&title={TITLE}";

jformat.live			=	"https://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&url={URL}&title={TITLE}&top=1";

jformat.facebook		=	"http://www.facebook.com/share.php?u={URL}";

jformat.twitter			=	"http://twitter.com/?status={TITLE}%20-%20{URL}";

jformat.stumbleupon		=	"http://www.stumbleupon.com/submit?url={URL}&title={TITLE}";

jformat.orkut			=	"http://promote.orkut.com/preview?nt=orkut.com&tt={TITLE}&du={URL}&cn={DESCRIPTION}";

jformat.bebo			=	"http://www.bebo.com/c/share?Url={URL}&title={TITLE}";

jformat.email			=	mail_link;

jformat.evernote		=	"http://s.evernote.com/grclip?url={URL}&title={TITLE}";

jformat.mixx			=	"http://www.mixx.com/submit?page_url={URL}&title={TITLE}";

jformat.myspace			=	"http://www.myspace.com/Modules/PostTo/Pages/?u={URL}&title={TITLE}";

jformat.netvibes		=	"http://www.netvibes.com/share?title={TITLE}&url={URL}";

jformat.tumblr			=	"http://www.tumblr.com/share?v=3&u={URL}&t={TITLE}&s=";

jformat.google_buzz		=	"http://www.google.com/reader/link?url={URL}&title={TITLE}&srcURL={URL}";

jformat.friendfeed		=	"http://friendfeed.com/share/bookmarklet/frame#title={TITLE}&url={URL}";

jformat.print			=	'javascript:void(0);" onClick="print_page();" target="_self';

jformat.favorites		=	'javascript:void(0);" onClick="bookmark_us();" target="_self';

jformat.design_moo		=	"http://www.designmoo.com/node/add/drigg/?url={URL}&title={TITLE}";

jformat.design_float	=	"http://www.designfloat.com/submit.php?url={URL}&title={TITLE}";

jformat.design_bump		=	"http://www.designbump.com/node/add/drigg/?url={URL}&title={TITLE}";

jformat.squidoo			=	"http://www.squidoo.com/lensmaster/bookmark?{URL}";

jformat.yahoo_buzz		=	"http://buzz.yahoo.com/buzz?targetUrl={URL}&headline={TITLE}&summary={DESCRIPTION}";

var share = settings.share.split(","); // Get buttons

		for ( var key in share ) {

			if (settings.share) {

			var services = share[key];

			var name = services.replace(/_/gi, " ");

			var url = jformat[services];

			if(url !== undefined){

				url = url.replace("{TITLE}"			, encodeURL(jshare_title()));

				url = url.replace("{URL}"			, encodeURL(jshare_url()));

				url = url.replace("{KEYWORDS}"		, encodeURL(jshare_metakeywords()));

				url = url.replace("{DESCRIPTION}"	, encodeURL(jshare_metadescription()));

				var sharelink = '<a href="' + url + '" class="jshare_button" title="' + name + '" ' + target + '><img border="0" src="' + settings.iconsdir + name + '.' + settings.imageextension + '" align="absmiddle" />	' + name + '</a>';

				if(notie6){ $(sharelink).appendTo('#jshare_share'); } // Add share buttons

			}

			}

		}

		

var bookmark = settings.bookmark.split(","); // Get buttons

		for ( var key in bookmark ) {

			if (settings.bookmark) {

			var services = bookmark[key];

			var name = services.replace(/_/gi, " ");

			var url = jformat[services];

			if(url !== undefined){

				url = url.replace("{TITLE}"			, encodeURL(jshare_title()));

				url = url.replace("{URL}"			, encodeURL(jshare_url()));

				url = url.replace("{KEYWORDS}"		, encodeURL(jshare_metakeywords()));

				url = url.replace("{DESCRIPTION}"	, encodeURL(jshare_metadescription()));

				var bookmarklink = '<a href="' + url + '" class="jshare_button" title="' + name + '" ' + target + '><img border="0" src="' + settings.iconsdir + name + '.' + settings.imageextension + '" align="absmiddle" />	' + name + '</a>';

				if(notie6){ $(bookmarklink).appendTo('#jshare_bookmark'); } // Add bookmark buttons 

			}

			}

		}		

		

if(settings.highlight) { // If highlight true

	$("#jshare_main a").fadeTo("fast", 0.7).hover(

												   function(){$(this).fadeTo("fast", 1.0);},

												   function(){$(this).fadeTo("fast",0.7);}

												   );

}

var jshare_tip = document.createElement('script');

jshare_tip.type = 'text/javascript';

jshare_tip.src = settings.jsharedir + 'jshare_tip.js';

$("body").append(jshare_tip);

// returns the jQuery object to allow for chainability.

		return this;

	};

})(jQuery);

function print_page(){

	$('#jshare-overlay').fadeOut('slow');

	$('#jshare_box').fadeOut('slow', function() {

											  window.print();

											  });

}

function bookmark_us() {

	alert('Press ctrl + D to bookmark');

}