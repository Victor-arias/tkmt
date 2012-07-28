<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Vídeos</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/video/agregar');?>">Agregar video</a></p>
	<?php if(!empty($videos)):?>
	<table>
		<tr>
			<th>Nombre</th>
            <th>Categoría</th>
            <th>Proveedor</th>
            <th>ID del video</th>
            <th>Fecha de publicación</th>
            <th>Editar</th>
		</tr>
		<?php foreach ($videos as $v):?>
			<tr>
				<td><?php echo $v->Nombre?></td>
                <td><?php echo $v->Nombre_categoria?></td>
                <td><?php echo $v->Nombre_proveedor?></td>
				<td class="video"><a class="iframe" href="<?php echo $v->Embed_URL.$v->Video_ID ?>" title="<?php echo $v->Nombre?>"><?php echo $v->Video_ID?></a></td>
                <td><?php echo $v->Fecha_publicacion?></td>
                <td><?php echo anchor('administracion/video/editar/'.$v->ID_video, 'Editar' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
    <?php else: ?>
    	<div class="alerta">Aún no hay vídeos para listar!</div>
    <?php endif;?>
</div>	

