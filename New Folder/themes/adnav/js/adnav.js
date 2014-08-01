
/**

  * Name: Titan Mega Menu

  * Date: September 2011

  * Autor: CreativeMilk

  * Version: 1.0

  * Lib: 1.6.1

  * Licence: NOT free

  * This is an CodeCanyon item

  * http://codecanyon.net/item/adnavmenu-a-fresh-and-powerfull-mega-menu/560330

  **/

(function($){

    jQuery.fn.adnavmenu = function(opt) { 

	 

	        // default settings(dont change) 

			var defaults = {

				effect: 'slide',  //effect

				speed: 200,       //speed of effect

			    style: 'black',   //color setting

				distance: 10,     //distance between button and box

				opacity: 1.0,     //opacity menu

				zIndex: 100,      //z-index

				delay: 0,         //mouseout delay,

				eventType: 'hover'//type of event

			};

			

			var opt = jQuery.extend(defaults, opt);

			return this.each(function() {  

													

				// variables

				var obj          = $(this);

				var items        = $("> li", obj);

				var objDiv       = $(this).find('div');

                var colWidth     = 161;

					// add color scheme

					obj.addClass('tmm-'+opt.style);

									

				    // set the effect

					if(opt.effect == 'fade'){

						var effectIn = 'fadeIn';

						var effectOut = 'fadeOut';	

						var speed = opt.speed;

					}else if(opt.effect == 'slide'){

						    effectIn = 'slideDown';

						    effectOut = 'slideUp';

						    speed = opt.speed;						

					}else if(opt.effect == 'slidefade'){

						    speed = opt.speed;					

					}else if(opt.effect == 'none'){

						    effectIn = 'show';

						    effectOut = 'hide';

						    speed = 0;	

					}

					

					// prepend a birdge to all menus										

					objDiv.each(function(){	

										

						//set right width for menu					

						var tCols = $(this).find('ul').length;

						var tWidth = tCols * colWidth;

						

						//set position menu(mirror)

						if($(this).hasClass('tmm-mirror')){

							var parentLi  = $(this).parent('li').width();

							var menuWidth = tWidth - parentLi;

							$(this).css({width: tWidth, left: -menuWidth}).prepend('<span class="tmm-bridge" style="right:0"></span>');	

						}else{

							$(this).css({width: tWidth, left: -1}).prepend('<span class="tmm-bridge" style="left:0"></span>');

						}

								

						// set bridge values

						var itemWidth     = $(this).parent('li').width();

						var itemHeight    = $(this).parent('li').height();

						var bridgeHeight  = opt.distance - itemHeight + 1;

						var bridgeTop     = opt.distance - itemHeight;

						

						if(itemHeight < opt.distance){

							$(this).children('span.tmm-bridge').css({height:bridgeHeight, width: itemWidth, top: -bridgeTop});	

						}					

							

					})

					// add opacity, zindex and distance to menu

					objDiv.css({opacity: opt.opacity, top: opt.distance, zIndex: opt.zIndex});

						if(opt.eventType == 'hover'){

							

							items.hover(function() {

				

								if(opt.effect == 'slidefade'){

									$(this).children('div').stop(true,true).animate({height: 'toggle', opacity: 'toggle'},speed);

								}else{

									$(this).children('div').stop(true,true)[effectIn](speed);

								}

							

							},function() {

	

								if(opt.effect == 'slidefade'){

									$(this).children('div').stop(true,true).delay(opt.delay).animate({height: 'toggle', opacity: 'toggle'},speed);

								}else{

									$(this).children('div').stop(true,true).delay(opt.delay)[effectOut](speed);

									

								}

								

							});

							

					    }else if(opt.eventType == 'click'){

							

							items.click(function() {

								

								if(opt.effect == 'slidefade'){

									$(this).children('div').stop(true,true).animate({height: 'toggle', opacity: 'toggle'},speed);

								}else{

									$(this).children('div').stop(true,true)[effectIn](speed);

								}

								

								return false;							

							});

							

							items.mouseleave(function() {

								

								if(opt.effect == 'slidefade'){

									$(this).children('div').stop(true,true).delay(opt.delay).animate({height: 'toggle', opacity: 'toggle'},speed);

								}else{

									$(this).children('div').stop(true,true).delay(opt.delay)[effectOut](speed);

									

								}							

							

							});

														

						}

		

			});		

		}

})(jQuery);

