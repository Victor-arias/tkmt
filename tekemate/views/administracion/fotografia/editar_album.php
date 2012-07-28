<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar álbum "<?php echo $a->Nombre;?>"</h2>

<div id="contenido">
	<p>Por favor modifique la información del álbum.</p>
	
    <?php echo form_open("administracion/fotografia/editar_album");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $a->Nombre);?>
      </p>
      
      <p><label for="Alias">Alias:</label>
      <?php echo form_input('Alias', $a->Alias);?> <span class="info">(para la URL amigable)</span>
      </p>
      
      <p><label for="Orden">Orden:</label>
      <?php echo form_dropdown('Orden', $Orden, $a->Orden);?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>$a->Activo, 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Editar" class="boton"/>
      <a href="<?php echo site_url('administracion/fotografia/eliminar_album/'.$a->ID_foto_album);?>" class="eliminar">Eliminar</a>
      </p>
      <?php echo form_hidden('ID_foto_album', $a->ID_foto_album);?>

      
    <?php echo form_close();?>

</div>