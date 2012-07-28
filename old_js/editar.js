$(function(){
	$(".eliminar").click(function(e){
		if(!confirm('Está seguro que lo desea eliminar?')){
			e.preventDefault();
			e.stopPropagation();
		}
	});
});