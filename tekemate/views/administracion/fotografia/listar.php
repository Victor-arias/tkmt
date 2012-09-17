<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Vídeos</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/fotografia/agregar'.$album);?>">Agregar fotografía</a></p>
	<?php if(!empty($fotos)):?>
	<table>
		<tr>
			<th>Vista previa</th>
			<th>Nombre</th>
            <th>Album</th>
            <!--<th>Editar</th>-->
            <th>Eliminar</th>
		</tr>
		<?php foreach ($fotos as $f):?>
			<tr>
				<td><img src="<?php echo base_url() . $f->Thumb?>" /></td>
				<td><?php echo $f->Nombre?></td>
                <td><?php echo $f->Nombre_album?></td>
                <!--<td><?php echo anchor('administracion/fotografia/editar/'.$f->ID_foto, 'Editar' );?></td>-->
                <td><?php echo anchor('administracion/fotografia/eliminar/'.$f->ID_foto, 'Eliminar' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
    <?php else: ?>
    	<div class="alerta">Aún no hay fotos para listar!</div>
    <?php endif;?>
</div>	

