<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->helper('form'); ?>
<h2>Recuperar Clave</h2>
<div id="contenido">
<p>Por favor ingrese su correo electrónico para enviarle una nueva clave.</p>

<?php $this->load->view('common/messages');?>

<?php echo form_open("administracion/usuario/recuperar_clave");?>

      <p>
      <label for="email">Correo Electrónico:</label>
      <?php echo form_input($email);?>
      </p>
      
      <p><input type="submit" name="submit" value="Recuperar clave" class="boton"/></p>
      
<?php echo form_close();?>
</div>