
/**
 * Coming soon
 * -----------
 *
 * author: Andrei Dinca
 * email: andrei.webdeveloper@gmail.com
 *
 * version 1.1 release date: 3.11.2010
 *
**/

var comingSoon = {
	o: {
		startZindex			: 999, // comments bellow on zIndexNumer functions
		diffSecs 			: 0, // start on item
		launchDate  		: '',
		interval 			: 0,
		transition  		: 'random',
		allEffect			: new Array('eff_1','eff_2','eff_3', 'random', 'fadeOut', 'splitAway', 'flipEffect'),
		duration			: 600,
		
		/* lightbox */
		lightboxColor		: '#000000', // lightbox fade color
		lightboxOpacity		: 0.6, // lightbox fade transparency
		lightboxInSpeed		: 500, // lightbox show box speed
		lightboxOutSpeed	: 200, // lightbox hide box speed
		lightboxInEasing	: 'easeInSine', // easing on show box
		lightboxOutEasing	: 'easeInSine' // easing hide box
		
	},
	// just init
	option:{},
	
	init: function(customOption){
		var self = this;
		
		// extend default option
		self.option = $.extend({}, self.o, customOption);
		
		self.setCountDown();
		
		self.option.interval = setInterval("comingSoon.setCountDown()", 1000);
		
		// init hover effect on any link
		self.linkHover();
		
		// init store newsletter subscribers
		self.storeSubscribers();
		
		self.lightbxoObserver();
	},
	
	linkHover: function(){
		var self = this;
		$("a").hover(function(){
			$(this).css('position', 'relative').animate({
				bottom: 2
			}, 200);
		}, function(){
			$(this).animate({
				bottom: "0px"
			}, 100);
		})
	},
	
	lightbxoObserver: function(){
		var self = this;
		$("a.subscribeLightbox").click(function(){
			self.createLightbox();
			
			return false;
		});
	},
	
	createLightbox: function(){
		var self = this;
		$("div#fade").remove();
		
		$("body").append('<div id="fade"></div>');
		$("div#fade").css({
			position: 'absolute',
			top: 0,
			left: 0,
			width: '100%',
			height: $("body").height(),
			backgroundColor: self.option.lightboxColor,
			opacity: 0,
			zIndex: 10000
		});
		
		$("div#fade").animate({
			opacity: self.option.lightboxOpacity
		}, self.option.lightboxInSpeed);
		
		$("div#boxRegister").css('z-index', 10001).animate({
			top: "50%",
			marginTop: "-120px"
		}, self.option.lightboxInSpeed, self.option.lightboxInEasing);
		
		
		$("div#fade").click(function(){
			self.deleteLightbox();
		});
		
	},
	
	deleteLightbox: function(){
		var self = this; 
		$("div#fade").animate({
			opacity: 0
		}, self.option.lightboxOutSpeed, function(){
			$("div#fade").remove();
		})
		
		$("div#boxRegister").css('z-index', 10001).animate({
			top: '-200px',
			marginTop: 0
		}, self.option.lightboxOutSpeed, self.option.lightboxOutEasing);
	},
	
	setCountDown: function (){
		var self = this; 
		
		if (self.option.launchDate){
			// target date
			// ex:   Tue Feb 15 2011 11:00:00 GMT+0200 (GTB Standard Time)
			targetTime = new Date(self.option.launchDate.month + '/' + self.option.launchDate.day + '/' + self.option.launchDate.year + ' ' + self.option.launchDate.hour + ':' + self.option.launchDate.min + ':' + self.option.launchDate.sec + (self.option.launchDate.utc ? ' UTC' : ''));
		}else if (self.option.targetOffset){
			alert('Plese setup launchDate!');
		}

		// current data
		// ex:  Sun Oct 24 2010 04:36:21 GMT+0300 (GTB Daylight Time)
		var curentData = new Date();
		
		// difference in seconds
		// ex: 9876113
		diffSecs = Math.floor((targetTime.valueOf()-curentData.valueOf())/1000);
		if(diffSecs < 1){
			//alert('Please select feature data!');
			clearInterval(self.option.interval);
		}

		// do countdown settings
		self.doCountDown('a', diffSecs, 500);
		
		return false;
	},
	
	doCountDown: function (id, diffSecs, duration){
		var self = this;
		
		var secs  = diffSecs % 60;
		var mins  = Math.floor(diffSecs/60)%60;
		var hours = Math.floor(diffSecs/60/60)%24;
		var days  = Math.floor(diffSecs/60/60/24);
		
		/*
		 * debug and testing - esential part
		 * -----------------
		 * mins: 8
		 * hours: 7
		 *
		 */
		//console.log( "secs: "+ secs );
		//console.log( "mins: "+ mins );
		//console.log( "hours: "+ hours ); 
		//console.log( "days: "+ days ); 
		
		self.countBlockChangeTo('seconds', secs);
		self.countBlockChangeTo('minutes', mins);
		self.countBlockChangeTo('hours', hours);
		self.countBlockChangeTo('days', days);
		return true;
	},
	
	countBlockChangeTo: function(block, value){
		var self = this;
		var posArr = [];
		var __defautTransition = '';
		
		// The simplest way to convert any variable to a string is to add an empty string to that variable
		if(value < 10){
			value = "0" + value;
		}else{
			value = value + "";
		}
		var splitValue_1 = value.substring(0, 1);
		var splitValue_2 = value.substring(1, 2);
		posArr[0] = parseInt(splitValue_1);
		posArr[1] = parseInt(splitValue_2);
		
		var currTransition = '';
		
		// particular case
		//eff_1, eff_2, eff_2
		if(self.option.transition == 'random'){
			self.option.allEffect.sort(self.randOrd);
			self.option.transition = self.option.allEffect[0];
		}else{
			__defautTransition = self.option.transition;
		}
		
		// do change
		self.numberToValue(block, posArr);
		
		// resetto default transition
		if(__defautTransition == 'random'){
			self.option.transition = 'random';
		}
		return true;
	},
	
	
/**
	 * numberToValue
	 * -----------
	 * 
	 * zIndex start from: 1000000000 (self.option.startZindex)
	 * Basically there are no limitations for z-index value in the CSS standard, 
	 * but I guess most browsers limit it to signed 32-bit values (-2147483648 to +2147483647) 
	 * in practice (64 would be a little off the top, and it doesn't make sense to use anything less than 32 bits these days)
	 */
	numberToValue: function(block, value, mode){
		var self = this;
		var ii = 0;
		var cc = 0;
		var zIndex = self.option.startZindex;
		
		// top part of number
		$("#" + block + " .top ul").each(function(cc){ 
		
			$(this).find('li').each(function(ii){
				var $this = $(this); // caching oobject
				$this.css('z-index', zIndex);	
				zIndex++;
				if($this.index() > value[cc]){
					// animate
					self.transitionEffect($this, 'top', 'animate');
				}else{
					self.transitionEffect($this, 'top', 'reset');			
				}
			});
		});
		
		// bottom part of number
		$("#" + block + " .bottom ul").each(function(cc){ 
			$(this).find('li').each(function(ii){
				var $this = $(this); // caching oobject
				$this.css('z-index', zIndex);	
				zIndex++;
				
				if($this.index() > value[cc]){
					// animate
					self.transitionEffect($this, 'bottom', 'animate');
				}else{
					self.transitionEffect($this, 'bottom', 'reset');
				}
			});
		});
	},
	
	// random array
	// more: http://javascript.about.com/library/blsort2.htm
	randOrd: function (){
		return (Math.round(Math.random())-0.5);
	},

	transitionEffect: function(curr, position, animate){
		var self = this;
		
		// switch transition. Config settings
		switch(self.option.transition){
			// effect 1
            case "eff_2": 
				if(animate == 'animate'){
					// top animate
					if(position == 'top'){
						curr.animate({
							bottom: -59
						}, self.option.duration);	
					}
					
					// bottom animate
					if(position == 'bottom'){
						curr.animate({
							top: -59
						}, self.option.duration);	
					}
				}
				
				if(animate == 'reset'){
					if(position == 'top'){
						// reset animate
						curr.css({
							bottom: 0
						});	
					}
					if(position == 'bottom'){
						// reset animate
						curr.css({
							top: 0
						});	
					}
				}
				break;
				
			case "eff_3": 
				if(animate == 'animate'){
					// top animate
					if(position == 'top'){
						curr.animate({
							top: -59,
							opacity: 0
						}, self.option.duration * 1.2, 'easeInBack');	
					}
					
					// bottom animate
					if(position == 'bottom'){
						curr.animate({
							bottom: -59,
							opacity: 0
						}, self.option.duration * 1.2, 'easeInBack');	
					}
				}
				
				if(animate == 'reset'){
					if(position == 'top'){
						// reset animate
						curr.css({
							top: 0,
							opacity: 1
						});	
					}
					if(position == 'bottom'){
						// reset animate
						curr.css({
							bottom: 0,
							opacity: 1
						});	
					}
				}
				break;	
				
			case "fadeOut": 
				if(animate == 'animate'){
					// top animate
					if(position == 'top'){
						curr.animate({
							opacity: 0
						}, self.option.duration, 'easeInBack');	
					}
					
					// bottom animate
					if(position == 'bottom'){
						curr.animate({
							opacity: 0
						}, self.option.duration, 'easeInBack');	
					}
				}
				
				if(animate == 'reset'){
					if(position == 'top'){
						// reset animate
						curr.css({
							opacity: 1
						});	
					}
					if(position == 'bottom'){
						// reset animate
						curr.css({
							opacity: 1
						});	
					}
				}
				break;

			case "splitAway": 
				if(animate == 'animate'){
					// top animate
					if(position == 'top'){
						curr.animate({
							left: -92,
							opacity: 0
						}, self.option.duration, '');	
					}
					
					// bottom animate
					if(position == 'bottom'){
						curr.animate({
							right: -92,
							opacity: 0
						}, self.option.duration, '');	
					}
				}
				
				if(animate == 'reset'){
					if(position == 'top'){
						// reset animate
						curr.css({
							left: 0,
							opacity: 1
						});	
					}
					if(position == 'bottom'){
						// reset animate
						curr.css({
							right: 0,
							opacity: 1
						});	
					}
				}
				break;
				
			case "flipEffect": 
				if(animate == 'animate'){
					// top animate
					if(position == 'top'){
						curr.animate({
							bottom: 60,
							right:100
						}, self.option.duration, 'easeInCirc');	
					}
					
					// bottom animate
					if(position == 'bottom'){
						curr.animate({
							top: 60,
							left:100
						}, self.option.duration , 'easeInCirc');	
					}
				}
				
				if(animate == 'reset'){
					if(position == 'top'){
						// reset animate
						curr.css({
							bottom: 0,
							right:0
						});	
					}
					if(position == 'bottom'){
						// reset animate
						curr.css({
							top: 0,
							left:0
						});	
					}
				}
				break;

            default: 
				// default effect
				if(animate == 'animate'){
					// top animate
					if(position == 'top'){
						curr.animate({
							bottom: -120,
							opacity: 0
						}, self.option.duration);	
					}
					
					// bottom animate
					if(position == 'bottom'){
						curr.animate({
							top: -120,
							opacity: 0
						}, self.option.duration);	
					}
				}
				
				if(animate == 'reset'){
					if(position == 'top'){
						// reset animate
						curr.css({
							bottom: 0,
							opacity: 1
						});	
					}
					if(position == 'bottom'){
						// reset animate
						curr.css({
							top: 0,
							opacity: 1
						});	
					}
				}
        }
	},
	
	storeSubscribers: function(){
		var self = this;
		
		$("#notificationsForm").submit(function(){
			// send email
			if(self.emailValidations()){
				var t=document.getElementById('sendnotifications').checked
				if(t==true){
					$.ajax({
				   type: "POST",
				    url:  "countdown/php/store.class.php",
				   data: "name=" + $("#name").val() + "&email=" + $("#email").val() + "&sendnotifications="+ ($("#sendnotifications").is(':checked') ? 'on' : 'off'),
				   success: function(msg){
					alert("Subscribe successful!");
					self.deleteLightbox();
					// reset prevent resend flood
					$("#name").val('Name');
					$("#email").val('Email');
				   }
				});
				}else{
					$.ajax({
				   type: "POST",
				    url:  "countdown/php/store.class1.php",
				   data: "name=" + $("#name").val() + "&email=" + $("#email").val() + "&sendnotifications="+ ($("#sendnotifications").is(':checked') ? 'on' : 'off'),
				   success: function(msg){
					alert("Subscribe successful!");
					self.deleteLightbox();
					// reset prevent resend flood
					$("#name").val('Name');
					$("#email").val('Email');
				   }
				});
				}
				
			}
			return false;
		});
	},
	
	/*
	 * javascript send email form validation
	 */
	emailValidations: function(){
		var self = this;
		
		var ErrorMsg = "Following fields must be completed.. \n\n";
		var Error = 0;
		
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = document.getElementById('email').value;
		
		//name validation start
		if(document.getElementById('name').value == "" ){
			ErrorMsg = ErrorMsg + "Please Provide Your  Name \n\n";
			Error = 1;
		}
		//name validation end
		
		//email validation start
		if(document.getElementById('email').value == "" )
		{
			ErrorMsg = ErrorMsg + "Please Provide Your Email \n\n";
			Error = 1;
		}
		else
		{
			if(reg.test(address) == false) {
				ErrorMsg = ErrorMsg + "Please Provide Your Valid Email Address \n\n";
				Error = 1;
			}
		}
		//email validation end
		
		//comments validation end		
		if(Error == 1){
			alert(ErrorMsg);
			return false;
		}
		else{
			return true;
		}
	}
}