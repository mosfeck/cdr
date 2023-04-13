/* Styles Switcher */

window.console = window.console || (function(){
	var c = {}; c.log = c.warn = c.debug = c.info = c.error = c.time = c.dir = c.profile = c.clear = c.exception = c.trace = c.assert = function(){};
	return c;
})();


jQuery(document).ready(function($) {
	"use strict"
	$("ul.colors .color1" ).click(function(){
		$("#colors" ).attr("href", "assets/css/colors/sky.css" );
		return false;
	});	
	$("ul.colors .color2" ).click(function(){
		$("#colors" ).attr("href", "assets/css/colors/blue.css" );
		return false;
	});	
	$("ul.colors .color3" ).click(function(){
		$("#colors" ).attr("href", "assets/css/colors/pink.css" );
		return false;
	});
	
	$("ul.colors .color4" ).click(function(){
		$("#colors" ).attr("href", "assets/css/colors/green.css" );
		return false;
	});	

	$("ul.colors .color5" ).click(function(){		
		$("#colors" ).attr("href", "assets/css/colors/orange.css" );
		return false;
	});

	$("ul.colors .color6" ).click(function(){
		$("#colors" ).attr("href", "assets/css/colors/yellow.css" );
		return false;
	});	
	

	$("#color-style-switcher .bottom a.settings").click(function(e){
		e.preventDefault();
		var div = $("#color-style-switcher");
		if (div.css("left") === "-45px") {
			$("#color-style-switcher").animate({
				left: "0px"
			}); 
		} else {
			$("#color-style-switcher").animate({
				left: "-45px"
			});
		}
	})

	$("#media-style-switcher .bottom a.settings").click(function (e) {
	    e.preventDefault();
	    var div = $("#media-style-switcher");
	    if (div.css("right") === "-45px") {
	        $("#media-style-switcher").animate({
	            right: "0px"
	        });
	    } else {
	        $("#media-style-switcher").animate({
	            right: "-45px"
	        });
	    }
	})

	//$("ul.colors li a").click(function(e){
	//	e.preventDefault();
	//	$(this).parent().parent().find("a").removeClass("active");
	//	$(this).addClass("active");
	//})

});



//Inject Necessary Styles and HTML
jQuery('head').append('<link rel="stylesheet" id="colors" href="assets/css/colors/sky.css" type="text/css" />');
jQuery('head').append('<link rel="stylesheet" href="assets/css/color-switcher.css" type="text/css" />'); 

jQuery('body').append('' + 
	'<div id="color-style-switcher">' +
		'<div>' + 
			'<ul class="social">' +
				'<li><a class="facebook" href="https://www.facebook.com/DhakaCCI/" target="_blank"><i class="fa fa-facebook"></i></a></li>' +
				'<li><a class="youtube" href="https://www.youtube.com/channel/UCC5d7b-4nh4BYVeFjBNcJ9g/" target="_blank"><i class="fa fa-youtube"></i></a></li>' +
				'<li><a class="webmail" href="#"><i class="fa fa-envelope"></i></a></li>' +
			'</ul>' +
		'</div>' +
		'<div class="bottom"> <a href="#" class="settings"><i class="fa fa-share-alt"></i></a> </div>' +
	'</div>' +
'');

//disable chat icon
//jQuery('body').append('' +
//	'<div id="media-style-switcher">' +
//		'<div>' +
//			'<ul class="media">' +
//				'<li><a class="chat" href="#"><i class="fa fa-comment"></i></a></li>' +
//			'</ul>' +
//		'</div>' +
//		'<div class="bottom"> <a href="#" class="settings"><i class="fa fab fa-stack-exchange"></i></a> </div>' +
//	'</div>' +
//'');

