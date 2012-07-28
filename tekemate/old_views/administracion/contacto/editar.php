<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Editar datos de contácto</h2>
<div id="contenido">
	<p>Por favor modifique la información de contacto.</p>
	
    <?php echo form_open("administracion/contacto/editar");?>
      <p><label for="Nombre">Nombre:</label>
      <?php echo form_input('Nombre', $c->Nombre);?>
      </p>
      
      <p><label for="Cargo">Cargo:</label>
      <?php echo form_input('Cargo', $c->Cargo);?>
      </p>
      
      <p><label for="Celular">Celular:</label>
      <?php echo form_input('Celular', $c->Celular);?>
      </p>
      
      <p><label for="Email">Correo electrónico:</label>
      <?php echo form_input('Email', $c->Email);?>
      </p>
      <?php if($c->Email_personal):?>
      <p><label for="Email">Correo electrónico personal:</label>
      <?php echo form_input('Email_personal', $c->Email_personal);?>
      </p>
      <?php endif;?>
      <p><input type="submit" name="submit" value="Editar" class="boton"/> 
      <?php echo form_hidden('ID_contacto', $c->ID_contacto);?>

    <?php echo form_close();?>

</div>