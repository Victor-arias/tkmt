<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Agregar servicio</h2>
<div id="contenido">
	<p>Por favor ingrese la información del servicio.</p>
	
    <?php echo form_open_multipart("administracion/servicios/agregar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre');?>
      </p>
      
      <p><label for="Intro">Intro:</label>
      <?php echo form_textarea('Intro');?>
      </p>
      
      <p><label for="Descripcion">Descripcion:</label>
      <?php echo form_textarea('Descripcion');?>
      </p>
      
      <p><label for="Imagen">Imagen:</label>
      <?php echo form_upload('Imagen');?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>'checked', 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Agregar" class="boton"/></p>
      
    <?php echo form_close();?>

</div>