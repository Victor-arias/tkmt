$(function(){
	$(".inner").css('width', $('.foto').width() * $('.foto').length * 2);

	$container = $('.fotos').children().eq(0);
	var $items = $container.children();
	var cantidad = $items.length;
	var incremento = $items.outerWidth(true);
	var en_slider = Math.floor($container.width() / incremento);
	var primerElemento = 1;
	var estaMoviendo = false;

	for(var i = 0; i < en_slider; i++){
		$container.append($items.eq(i).clone());
	}
	$('.fotos .next').click(function(e){
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
	$('.fotos .prev').click(function(e){
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