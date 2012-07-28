<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar banner "<?php echo $b->Nombre;?>"</h2>

<div id="contenido">
	<p>Por favor modifique la información del banner.</p>
	
    <?php echo form_open_multipart("administracion/banner/editar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $b->Nombre);?>
      </p>
      
      <p><label for="Url">Url:</label>
      <?php echo form_input('Url', $b->Url);?>
      </p>
      
      <p><label for="Imagen">Imagen:</label>
      <a href="<?php echo base_url().$b->mUrl ?>" class="fancybox"><img src="<?php echo base_url().$b->tUrl?>" width="<?php echo $b->tAncho?>" height="<?php echo $b->tAlto?>" alt="<?php echo $b->tTexto_alternativo?>"/></a>
      <br />
      Cambiar imagen: <?php echo form_upload('Imagen');?>
      </p>
      
      <p><label for="Publicar">Publicar:</label>
      <?php
	   $publicar = array('name'=>'Publicar', 'checked'=>$b->Publicado, 'value'=>'1');
	   echo form_checkbox($publicar);?>
      </p>
      
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>$b->Activo, 'value'=>'1');
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Editar" class="boton"/>
      <a href="<?php echo site_url('administracion/banner/eliminar_imagen/'.$b->ID_banner);?>" class="eliminar">Eliminar</a>
      </p>
      <?php echo form_hidden('ID_banner', $b->ID_banner);?>

      
    <?php echo form_close();?>

</div>