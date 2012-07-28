<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Servicios</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/servicios/agregar');?>">Agregar servicio</a></p>
	
	<?php //$this->load->view('common/messages');?>
	
	<table>
		<tr>
			<th>Nombre</th>
            <th>Editar</th>
		</tr>
		<?php foreach ($servicios as $s):?>
			<tr>
				<td><?php echo $s->Nombre?></td>
                <td><?php echo anchor('administracion/servicios/editar/'.$s->ID_servicio, 'Editar' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>	

