<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Usuarios</h2>
<div id="contenido">
	<p><a class="crear" href="<?php echo site_url('administracion/usuario/crear_usuario');?>">Nuevo usuario</a></p>
	
	<?php //$this->load->view('common/messages');?>
	
	<table>
		<tr>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Correo electrónico</th>
			<th>Grupo</th>
			<th>Acciones</th>
		</tr>
		<?php foreach ($usuarios as $usuario):?>
			<tr>
				<td><?php echo $usuario['Nombre']?></td>
				<td><?php echo $usuario['Apellido']?></td>
				<td><?php echo $usuario['email'];?></td>
				<td><?php echo $usuario['group_description'];?></td>
                <td><?php echo anchor("administracion/usuario/editar/".$usuario['Id_usuario'], 'Editar'); ?> - <?php echo anchor("administracion/usuario/cambiar_clave/".$usuario['Id_usuario'], 'Cambiar clave'); ?></td>
				<!--<td><?php echo ($usuario['active']) ? anchor("administracion/usuario/desactivar/".$usuario['Id_usuario'], 'Desactivar') : anchor("administracion/usuario/activar/". $usuario['Id_usuario'], 'Activar');?></td>-->
			</tr>
		<?php endforeach;?>
	</table>
</div>	

