<h2>Contáctenos</h2>
<p class="descripcion">¡Hola! <br />
En Tekemate estamos atentos a cualquier inquietud sobre nuestros servicios. <br />
Por favor, escribanos si tiene alguna y en la menor brevedad le daremos respuesta.</p>
<div id="contact_form">
<?php echo form_open('contacto');?>
<p>
<?php echo form_label('Nombre / Compañía:', 'Nombre'); ?>
<?php echo form_input('Nombre', '', 'id="Nombre"');?>
</p>
<p>
<?php echo form_label('Correo:', 'Correo'); ?>
<?php echo form_input('Correo', '', 'id="Correo"');?>
</p>
<p>
<?php echo form_label('Mensaje:', 'Mensaje'); ?>
<?php echo form_textarea('Mensaje', '', 'id="Mensaje"');?>
</p>
<p>
<?php echo form_label('¿Cuánto es 3+2?', 'Validacion'); ?>
<?php echo form_input('Validacion', '', 'id="Validacion"');?>
</p>
<p>
<?php echo form_submit('Enviar', 'Enviar', 'class="submit"'); ?>
</p>
<?php echo form_close();?>
</div>
<div id='contact_data'>
	<h3>UBICACIÓN DE TEKEMATE:</h3>
    <h4>En el mapa:</h4>
    <p><a href="http://goo.gl/maps/HJ5U">Calle 45 D # 76A - 03<br />
    Medellín, Antioquia<br />
    Colombia</a></p>
    <h4>En el teléfono:</h4>
    <p>Fijo: (57+4) 411 4777<br />
    Movil: (57) <?php echo $contacto->Celular?></p>
    <h4>En el mail:</h4>
    <p><?php echo $contacto->Email?></p>
</div>