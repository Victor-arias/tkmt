<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar servicio "<?php echo $s->Nombre;?>"</h2>
<div id="contenido">
	<p>Por favor modifique la información del servicio.</p>
	<?php //$this->load->view('common/messages');?>
	
    <?php echo form_open_multipart("administracion/servicios/editar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $s->Nombre);?>
      </p>
      
      <p><label for="Intro">Intro:</label>
      <?php echo form_textarea('Intro', $s->Intro);?>
      </p>
      
      <p><label for="Descripcion">Descripcion:</label>
      <?php echo form_textarea('Descripcion', $s->Descripcion);?>
      </p>
      
      <p><label for="Imagen">Imagen:</label>
      <img src="<?php echo base_url().'fotos/servicios/'.$s->Thumb;?>" alt="<?php echo $s->Nombre?>" />
      <br />
      Cambiar imagen: <?php echo form_upload('Imagen');?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>$s->Activo);
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Editar" class="boton"/>
      <a href="<?php echo site_url('administracion/servicios/eliminar/'.$s->ID_servicio);?>" class="eliminar">Eliminar</a>
      </p>
      <?php echo form_hidden('ID_servicio', $s->ID_servicio);?>

      
    <?php echo form_close();?>

</div>