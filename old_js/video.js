$(function(){
	$(".video a").fancybox({'padding':0,'width':640,'height':360,'overlayOpacity':0.9, 'overlayColor':'#000'});
	
	/*$(".video a").click(function(){
		/*$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'title'         : this.title,
			'width'         : 640,
			'height'        : 385,
			'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),	
			'type'			: 'swf',
			'swf'			: {
								'wmode'             : 'transparent',
								'allowfullscreen'   : 'true'
							}
		});*/
		/*var Vwidth = $(window).width();
		var Vheight = $(window).height();
		$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: 640/*Vwidth*0.9 /*640*//*,
			/*'height'		: 360/*Vheight*0.9/*385*//*,
			/*'href'			: this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?show_title=1&show_byline=0&show_portrait=1&color=&fullscreen=1&clip_id=$1'),
			'type'			: 'swf'
		});
        return false;
	});*/
});