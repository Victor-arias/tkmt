<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Agregar imagen (banner)</h2>
<div id="contenido">
	<p>Por favor ingrese la información de la imagen.</p>
	
    <?php echo form_open_multipart("administracion/banner/agregar_imagen");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre');?>
      </p>
      
      <p><label for="Url">Url:</label>
      <?php echo form_input('Url');?>
      </p>
      
      <p><label for="Imagen">Imagen:</label>
      <?php echo form_upload('Imagen');?>
      </p>
      
      <p><label for="Publicar">Publicar:</label>
      <?php
	   $publicar = array('name'=>'Publicar', 'checked'=>'checked', 'value'=>'1');
	   echo form_checkbox($publicar);?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>'checked', 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Agregar" class="boton"/></p>
      
    <?php echo form_close();?>

</div>