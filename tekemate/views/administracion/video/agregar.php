<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Agregar vídeo</h2>
<div id="contenido">

	<p>Por favor ingrese la información del vídeo nuevo.</p>
	
    <?php echo form_open_multipart("administracion/video/agregar");?>
      <p><label for="Categoria">Categoría:</label>
      <?php echo form_dropdown('Categoria', $Categoria, $ID_categoria_video);?>
      </p>
      
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre');?>
      </p>
      
      <p><label for="Descripcion">Descripción:</label>
      <?php echo form_textarea('Descripcion');?>
      </p>
      
      <p><label for="Proveedor">Proveedor:</label>
      <?php echo form_dropdown('Proveedor', $Proveedor);?>
      </p>
      
      <p><label for="Video_ID">ID del video:</label>
      <?php echo form_input('Video_ID');?>
      </p>
      
      <p><label for="Thumb">Vista previa:</label>
      <?php echo form_upload('Thumb');?>
      </p>
    
      <p><input type="submit" name="submit" value="Agregar vídeo" class="boton"/></p>

      
    <?php echo form_close();?>

</div>
