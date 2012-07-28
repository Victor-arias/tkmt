<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Agregar recomendado</h2>
<div id="contenido">

	<p>Por favor ingrese la información del recomendado nuevo.</p>
	
	<?php //$this->load->view('common/messages');?>
	
    <?php echo form_open("administracion/recomendado/agregar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre');?>
      </p>
      
      <p><label for="Proveedor">Proveedor:</label>
      <?php echo form_dropdown('Proveedor', $Proveedor);?>
      </p>
      
      <p><label for="Video_ID">ID del video:</label>
      <?php echo form_input('Video_ID');?>
      </p>
      
      <p><label for="Publicado">Publicado:</label>
      <?php echo form_checkbox('Publicado', 1);?>
      <span>(Automáticamente despublica el anterior)</span>
      </p>
      
      <p><input type="submit" name="submit" value="Agregar recomendado" class="boton"/></p>

      
    <?php echo form_close();?>

</div>
