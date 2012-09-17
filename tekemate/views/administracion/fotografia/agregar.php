<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Agregar fotografía</h2>
<div id="contenido">

	<p>Por favor ingrese la información de la fotografía nueva.</p>
	
    <?php echo form_open_multipart("administracion/fotografia/agregar");?>
      <p><label for="Foto_album">Album:</label>
      <?php echo form_dropdown('Foto_album', $Foto_album, $ID_foto_album);?>
      </p>
      
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre');?>
      </p>

      <p><label for="Foto">Fotografía:</label>
      <?php echo form_upload('Foto');?>
      </p>
  
      <p><input type="submit" name="submit" value="Agregar fotografía" class="boton"/></p>
      
    <?php echo form_close();?>

</div>
