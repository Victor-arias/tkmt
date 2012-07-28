<h2>Contáctenos</h2>
<p class="descripcion">¡Sé parte de nuestro equipo! y disfruta de las ventajas que ofrece la producción audiovisual para ti y tu negocio.</p>
<?php echo form_open('contacto');?>
<p>
<?php echo form_label('Nombre', 'Nombre'); ?>
<?php echo form_input('Nombre', '', 'id="Nombre"');?>
</p>
<p>
<?php echo form_label('Correo', 'Correo'); ?>
<?php echo form_input('Correo', '', 'id="Correo"');?>
</p>
<p>
<?php echo form_label('Mensaje', 'Mensaje'); ?>
<?php echo form_textarea('Mensaje', '', 'id="Mensaje"');?>
</p>
<p>
<?php echo form_label('Cuánto es 3+2?', 'Validacion'); ?>
<?php echo form_input('Validacion', '', 'id="Validacion"');?>
</p>
<p>
<?php echo form_submit('Enviar', 'Enviar mensaje', 'class="submit"'); ?>
</p>
<?php echo form_close();?>

