<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Crear nuevo Usuario</h2>
<div id="contenido">

	<p>Por favor ingrese la información del usuario nuevo.</p>
	
	<?php $this->load->view('common/messages');?>
	
    <?php echo form_open("administracion/usuario/crear_usuario");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input($Nombre);?>
      </p>
      
      <p><label for="Apellido">Apellido:</label>
      <?php echo form_input($Apellido);?>
      </p>
      
      <p><label for="email">Correo electrónico:</label>
      <?php echo form_input($email);?>
      </p>
      
      <p><label for="password">Clave:</label>
      <?php echo form_input($password);?>
      </p>
      
      <p><label for="password_confirm">Confirmar clave:</label>
      <?php echo form_input($password_confirm);?>
      </p>
      
      
      <p><input type="submit" name="submit" value="Crear usuario" class="boton"/></p>

      
    <?php echo form_close();?>

</div>
