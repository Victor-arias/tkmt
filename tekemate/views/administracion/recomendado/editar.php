<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar recomendado "<?php echo $r->Nombre;?>"</h2>
<div id="contenido">
	<p>Por favor modifique la información del recomendado.</p>
	<?php //$this->load->view('common/messages');?>
	
    <?php echo form_open("administracion/recomendado/editar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $r->Nombre);?>
      </p>
      
      <p><label for="Proveedor">Proveedor:</label>
      <?php echo form_dropdown('Proveedor', $Proveedor, $r->ID_proveedor_video);?>
      </p>
      
      <p><label for="Video_ID">ID del video:</label>
      <?php echo form_input('Video_ID', $r->Video_ID);?>
      </p>
      
      <p><label for="Publicado">Publicado:</label>
      <?php 
	  $publicado = array('name'=>'Publicado', 'checked'=>$r->Publicado);
	  if($r->Publicado) $publicado['disabled'] = 'disabled';
	  echo form_checkbox($publicado);?>
      <?php if($r->Publicado):?><span>Para despublicar este recomendado, debe publicar otro.</span>
      <?php else:?><span>(Automáticamente despublica el anterior)</span> <?php endif;?>
      </p>
                  
      <p><label for="Activo">Activo:</label>
      <?php
	   $activo = array('name'=>'Activo', 'checked'=>$r->Activo);
	   echo form_checkbox($activo);?>
      </p>
      
      <p><input type="submit" name="submit" value="Editar" class="boton"/> 
	  <?php if(!$r->Publicado): ?>
      <a href="<?php echo site_url('administracion/recomendado/eliminar/'.$r->ID_recomendado);?>" class="eliminar">Eliminar</a>
      <?php endif;?></p>
      <?php echo form_hidden('ID_recomendado', $r->ID_recomendado);?>

      
    <?php echo form_close();?>

</div>