$(function(){
	//$(".video a").fancybox({'padding':0,'width':640,'height':360,'overlayOpacity':0.9, 'overlayColor':'#000'});
	$(".inner").css('width', $('.video').width() * $('.video').length * 2);

	$container = $('.videos').children().eq(0);
	var $items = $container.children();
	var cantidad = $items.length;
	var incremento = $items.outerWidth(true);
	var en_slider = Math.floor($container.width() / incremento);
	var primerElemento = 1;
	var estaMoviendo = false;

	for(var i = 0; i < en_slider; i++){
		$container.append($items.eq(i).clone());
	}
	$('.videos .next').click(function(e){
		e.preventDefault();
		console.log('slider primerElemento ' + primerElemento);
		if(!estaMoviendo){
			if(primerElemento > cantidad){
				$container.css('left', '0px');
				primerElemento = 2;
			}else{
				primerElemento++;
			}
			estaMoviendo = true;
			$container.animate({
				left: '-=' + incremento,
			},'swing', function(){
				estaMoviendo = false;
			});
		}
	}); 
	$('.videos .prev').click(function(e){
		e.preventDefault();
		if(!estaMoviendo){
			if(primerElemento == 1){
				$container.css('left', cantidad * incremento * -1);
				primerElemento = cantidad;
			}else{
				primerElemento--;
			}
			estaMoviendo = true;
			$container.animate({
				left: '+=' + incremento,
			},'swing', function(){
				estaMoviendo = false;
			});
		}
	});


});