<style type="text/css">
	body{background: rgba(63, 63, 63, .7); font-family: Rockwell, "Courier Bold", Courier, Georgia, Times, "Times New Roman", serif; font-size: 12px; letter-spacing: 0.6px;  padding: 25px;}
	h2{color: #B2B2B2; margin-top: 0; text-align: center; text-transform: uppercase;}
	
	#servicio{height: 490px; overflow: hidden;}
	
	#featured{float: right; padding: 0 20px; width: 500px;}
	#featured p{color: #FFF;}
	
	#sidebar{border-right: thin solid #FFF; float: left; /*height: 440px; overflow: hidden;*/ padding: 0 10px; width: 155px;}
	#sidebar ul{list-style: none; margin:0; padding:0;}
	#sidebar li{height: 100px; margin-bottom: 15px; position: relative; width: 155px;}
	#sidebar p{background: #000; bottom: 0; color: #FFF; display: none; margin: 0; opacity: 0; padding: 2%; position: absolute; width:96%;}
	#sidebar li a{color: #FFF; text-decoration: none;}
	#sidebar li:hover p{display: block; opacity: 1;}
</style>
<div id="servicio">
<h2><?php echo $servicio;?></h2>
   <div id="featured">
	   	<iframe width="490" height="276" src="http://www.youtube.com/embed/BVa5ZMLsb6o" frameborder="0" allowfullscreen></iframe>
        <p>Tekemate se especializa en la producción de contenidos audiovisuales para el desarrollo de proyectos estratégicos empresariales, con base en el acompañamiento continuo y personalizado.</p>
   </div>
   <div id="sidebar">
   		<ul>
        	<li><a class='image' href='<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara.jpg' title='Book Luisa Guevara'><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara_thumb.jpg" width="155" height="100" alt="Book luisa guevara"/><p>Book Luisa Guevara</p></a></li>
            <li><a class='image' href='<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara1.jpg' title='Book Luisa Guevara 1'><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara1_thumb.jpg" width="155" height="100" alt="Book luisa guevara"/><p>Book Luisa Guevara 1</p></a></li>
            <li><a class='video' href='http://www.youtube.com/embed/BVa5ZMLsb6o' title='Book Luisa Guevara 3'><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara2_thumb.jpg" width="155" height="100" alt="Book luisa guevara"/><p>Book Luisa Guevara 2</p></a></li>
            <li><a class='image' href='<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara.jpg' title='Book Luisa Guevara'><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara_thumb.jpg" width="155" height="100" alt="Book luisa guevara"/><p>Book Luisa Guevara</p></a></li>
            <li><a class='image' href='<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara1.jpg' title='Book Luisa Guevara 1'><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara1_thumb.jpg" width="155" height="100" alt="Book luisa guevara"/><p>Book Luisa Guevara 1</p></a></li>
            <li><a class='video' href='http://www.youtube.com/embed/BVa5ZMLsb6o' title='Book Luisa Guevara 3'><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara2_thumb.jpg" width="155" height="100" alt="Book luisa guevara"/><p>Book Luisa Guevara 2</p></a></li>
        </ul>
   </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url();?>js/libs/jquery-1.6.4.min.js"><\/script>')</script>
<script type="text/javascript" src="<?php echo base_url();?>js/libs/ui.core-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/libs/ui.draggable-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/libs/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/libs/plugin.scrollbar.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#sidebar").scrollbar();
		$('#sidebar a').click(function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			var type = $(this).attr('class');
			var title = $(this).attr('title');
			var html = '';
			switch(type){
				case 'image':
					html += '<img src="'+ url +'" alt="'+ title +'" /><p>'+ title +'</p>';
					break;
				case 'video':
					html += '<iframe width="490" height="276" src="'+ url +'" frameborder="0" allowfullscreen></iframe><p>'+ title +'</p>';
					break;
			}
		    $('#featured').html(html);
		});
	});
	</script>
<script type="text/javascript">
  var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-24776889-1']); _gaq.push(['_trackPageview']); (function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
</script>