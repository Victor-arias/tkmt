<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar categoría "<?php echo $c->Nombre;?>"</h2>

<div id="contenido">
	<p>Por favor modifique la información de la categoría.</p>
	
    <?php echo form_open("administracion/categoria_video/editar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $c->Nombre);?>
      </p>
      
      <p><label for="Alias">Alias:</label>
      <?php echo form_input('Alias', $c->Alias);?> <span class="info">(para la URL amigable)</span>
      </p>
      
      <p><label for="Descripcion">Descripción:</label>
      <?php echo form_textarea('Descripcion', $c->Descripcion);?>
      </p>
      
      <p><label for="Orden">Orden:</label>
      <?php echo form_dropdown('Orden', $Orden, $c->Orden);?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>$c->Activo, 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Editar" class="boton"/>
      <a href="<?php echo site_url('administracion/categoria_video/eliminar/'.$c->ID_categoria_video);?>" class="eliminar">Eliminar</a>
      </p>
      <?php echo form_hidden('ID_categoria_video', $c->ID_categoria_video);?>

      
    <?php echo form_close();?>

</div>