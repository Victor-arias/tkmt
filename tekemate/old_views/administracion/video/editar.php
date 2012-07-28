<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar vídeo "<?php echo $v->Nombre;?>"</h2>
<div id="contenido">
	<p>Por favor modifique la información del vídeo.</p>
	
    <?php echo form_open_multipart("administracion/video/editar");?>
    	<p><label for="Categoria">Categoría:</label>
      <?php echo form_dropdown('Categoria', $Categoria, $v->ID_categoria_video);?>
      </p>
    
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $v->Nombre);?>
      </p>
      
      <p><label for="Alias">Alias:</label>
      <?php echo form_input('Alias', $v->Alias);?>
      </p>
      
      <p><label for="Descripcion">Descripción:</label>
      <?php echo form_textarea('Descripcion', $v->Descripcion);?>
      </p>
      
      <p><label for="Proveedor">Proveedor:</label>
      <?php echo form_dropdown('Proveedor', $Proveedor, $v->ID_proveedor_video);?>
      </p>
      
      <p><label for="Video_ID">ID del video:</label>
      <?php echo form_input('Video_ID', $v->Video_ID);?>
      </p>
      
      <p><label for="Thumb">Vista previa:</label>
      <a href="<?php echo base_url().$v->Url ?>" class="fancybox"><img src="<?php echo base_url().$v->Url?>" width="<?php echo $v->Ancho?>" height="<?php echo $v->Alto?>" alt="<?php echo $v->Texto_alternativo?>"/></a>
      <br />
      Cambiar vista previa:
      <?php echo form_upload('Thumb');?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>$v->Activo, 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Editar" class="boton"/> 
      <a href="<?php echo site_url('administracion/video/eliminar/'.$v->ID_video);?>" class="eliminar">Eliminar</a>
      <?php echo form_hidden('ID_video', $v->ID_video);?>

      
    <?php echo form_close();?>

</div>