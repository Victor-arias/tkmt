<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->helper('form'); ?>
<h2>Cambiar Clave</h2>
<div id="contenido">
<?php $this->load->view('common/messages');?>

<?php echo form_open("administracion/usuario/cambiar_clave");?>

      <p>Clave vieja:<br />
      <?php echo form_input($old_password);?>
      </p>
      
      <p>Clave nueva:<br />
      <?php echo form_input($new_password);?>
      </p>
      
      <p>Confirmar clave nueva:<br />
      <?php echo form_input($new_password_confirm);?>
      </p>
      
      <?php echo form_input($Id_usuario);?>
      <p><input type="submit" name="submit" value="Cambiar clave" class="boton"/></p>
      
<?php echo form_close();?>
</div>