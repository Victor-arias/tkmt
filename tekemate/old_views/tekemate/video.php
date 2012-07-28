<h2>Vídeo</h2>
<p class="descripcion">Te brindamos la oportunidad de trasmitir por medio de imágenes y audio el sentir de tu compañía con la capacidad de promocionarse por si mismo, con los más altos estándares de calidad y en diferentes formatos.</p>
<div class="videos">
<?php foreach($videos as $v):?>
	<div class="video">
    	
        <a class="iframe" href="http://player.vimeo.com/video/<?php echo $v->id;?>?title=0&amp;byline=0&amp;portrait=0"><img src="<?php echo $v->thumbnail_medium;?>" width="200" height="150"/></a>
        <h3><?php echo $v->title;?></h3>
        
    </div>
<?php endforeach;?>
</div>
<!--

<div class="video">
    <h3>Book Ivon Marín</h3>
    <ul>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin.jpg" class="fancybox" rel="ivon-marin" title="Por si se desea añadir una descripción de la foto, es posible!"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin1.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin1_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin3.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin3_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
       <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin5.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin5_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
       <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin6.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin6_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
    </ul>
  </div>
  <div class="video">
    <h3>Book Luisa Guevara</h3>
    <ul>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara.jpg" class="fancybox" rel="luisa-guevara"><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara1.jpg" class="fancybox" rel="luisa-guevara"><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara1_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara2.jpg" class="fancybox" rel="luisa-guevara"><img src="<?php echo base_url() ?>fotos/galeria/book-luisa-guevara/Book-Luisa-Guevara2_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
    </ul>
  </div>
  <div class="video">
    <h3>Merchan MCH - Un crudo referente</h3>
    <ul>
      <li><a href="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente.jpg" class="fancybox" rel="merchan"><img src="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente2.jpg" class="fancybox" rel="merchan"><img src="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente2_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente3.jpg" class="fancybox" rel="merchan"><img src="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente3_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente4.jpg" class="fancybox" rel="merchan"><img src="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente4_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente6.jpg" class="fancybox" rel="merchan"><img src="<?php echo base_url() ?>fotos/galeria/merchan-mch/Merchan-MCH-Un-Crudo-Referente6_thumb.jpg" width="112" height="112" alt="Merchan MCH - Un crudo referente"/></a></li>
 
	</ul>
  </div>
  <div class="video">
    <h3>Book Carolina Marín</h3>
    <ul>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin.jpg" class="fancybox" rel="ivon-marin" title="Por si se desea añadir una descripción de la foto, es posible!"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin1.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin1_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
      <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin3.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin3_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
       <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin5.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin5_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
       <li><a href="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin6.jpg" class="fancybox" rel="ivon-marin"><img src="<?php echo base_url() ?>fotos/galeria/book-ivon-marin/Book-Ivon-Marin6_thumb.jpg" width="112" height="112" alt="Book Ivon Marín"/></a></li>
    </ul>
  </div>

  <div class="video">
    <h3>Teaser cortometraje Sambenito</h3>
    <ul>
      <li><a href="http://www.youtube.com/watch?v=uEb7pHFIDeM" class="video" rel="sambenito"><img src="<?php echo base_url() ?>fotos/galeria/teaser-cortometraje-sambenito/balon_thumb.jpg" width="112" height="112" alt="Teaser cortometraje Sambenito"/></a></li> 
      <li><a href="http://www.youtube.com/watch?v=uEb7pHFIDeM" class="video" rel="sambenito"><img src="<?php echo base_url() ?>fotos/galeria/teaser-cortometraje-sambenito/calvo_thumb.jpg" width="112" height="112" alt="Teaser cortometraje Sambenito"/></a></li> 
	</ul>
  </div>
  
  
</div>
-->