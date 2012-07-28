<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->helper('form'); ?>
<h2>Iniciar Sesión</h2>
<div id="contenido" class="login">
	<p>Por favor inicie sesión con su correo electrónico y su clave.</p>
	
	<?php //$this->load->view('common/messages');?>
	
    <?php echo form_open("administracion/usuario/iniciar_sesion");?>
    	
      <p>
      	<label for="email">Correo electrónico:</label>
      	<?php echo form_input($email);?>
      </p>
      
      <p>
      	<label for="password">Clave:</label>
      	<?php echo form_input($password);?>
      </p>
      
      <p>
	      <label for="remember">Recordarme:</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?>
	  </p>
      
      
      <p><input type="submit" name="submit" value="Iniciar sesión" class="boton"/></p>

      
    <?php echo form_close();?>
    <p><a href="<?php echo site_url('administracion/usuario/recuperar_clave')?>">Olvidó su clave?</a></p>

</div>
