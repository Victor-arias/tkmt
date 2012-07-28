<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Recomendado</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/recomendado/agregar');?>">Agregar recomendado</a></p>
	
	<?php //$this->load->view('common/messages');?>
	
	<table>
		<tr>
			<th>Nombre</th>
            <th>Proveedor</th>
            <th>ID del video</th>
            <th>Fecha de publicación</th>
			<th>Publicado</th>
            <th>Editar</th>
		</tr>
		<?php foreach ($recomendados as $r):?>
			<tr <?php if($r->Publicado) echo 'class="publicado"'?>>
				<td><?php echo $r->Nombre?></td>
                <td><?php echo $r->Nombre_proveedor?></td>
				<td><?php echo $r->Video_ID?></td>
                <td><?php echo $r->Fecha_publicacion?></td>
				<td><?php echo $r->Publicado?></td>
                <td><?php echo anchor('administracion/recomendado/editar/'.$r->ID_recomendado, 'Editar' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>	

