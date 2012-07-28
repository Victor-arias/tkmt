<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar Usuario</h2>
<div id="contenido">	
<p>Por favor modifique la información que desee del usuario.</p>
	
	<?php //$this->load->view('common/messages');?>
	
    <?php echo form_open("administracion/usuario/editar/".$this->uri->segment(4));?>
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
      
      <!--<p>
      	<input type="checkbox" name="reset_password"> <label for="reset_password">Resetear clave</label>
      </p>-->
      
      <?php echo form_input($Id_usuario);?>
      <p><input type="submit" name="submit" value="Editar usuario" class="boton"/></p>

      
    <!--<?php echo form_close();?>
	<a href="<?php echo site_url("aministracion/usuario/borrar/".$this->uri->segment(4));?>" class="borrar"/>-->
</div>
