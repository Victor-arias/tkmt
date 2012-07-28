<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Agregar categoría (Vídeo)</h2>
<div id="contenido">
	<p>Por favor ingrese la información de la categoría.</p>
	
    <?php echo form_open("administracion/categoria_video/agregar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre');?>
      </p>
      
      <p><label for="Descripcion">Descripción:</label>
      <?php echo form_textarea('Descripcion');?>
      </p>
      
      <p><label for="Orden">Orden:</label>
      <?php echo form_dropdown('Orden', $Orden);?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>'checked', 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Agregar" class="boton"/></p>
      
    <?php echo form_close();?>

</div>