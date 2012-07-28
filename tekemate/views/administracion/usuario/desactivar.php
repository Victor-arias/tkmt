<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Desactivar Usuario</h2>
<div id="contenido">

	<p>Está seguro que desea desactivar el usuario '<?php echo $usuario['username']; ?>'</p>
	
    <?php echo form_open("administracion/usuario/desactivar/".$usuario['Id_usuario']);?>
    	
      <p>
      	<label for="confirm">Si:</label>
		<input type="radio" name="confirm" value="yes" checked="checked" />
      	<label for="confirm">No:</label>
		<input type="radio" name="confirm" value="no" />
      </p>
      
      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(array('Id_usuario'=>$usuario['Id_usuario'])); ?>
      
      <p><input type="submit" name="submit" value="Desactivar" class="boton"/></p>

    <?php echo form_close();?>

</div>
