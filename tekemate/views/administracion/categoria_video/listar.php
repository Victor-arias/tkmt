<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Categorías (Vídeo)</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/categoria_video/agregar');?>">Agregar categoría</a></p>
	<table>
		<tr>
            <th>Nombre</th>
            <th>Alias</th>
            <th>Descripcion</th>
            <th>Editar</th>
		</tr>
		<?php
		 foreach ($categorias as $c):?>
			<tr>
            	<td><a href="<?php echo site_url('administracion/categoria_video/ver/'.$c->ID_categoria_video) ?>" title="Ver videos de la categoría <?php echo $c->Nombre;?>"><?php echo $c->Nombre;?></a></td>
                <td><a href="<?php echo site_url('video/'.$c->Alias) ?>"><?php echo $c->Alias;?></a></td>
                <td><?php echo $c->Descripcion?></td>
                <td><?php echo anchor('administracion/categoria_video/editar/'.$c->ID_categoria_video, 'Editar' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>	

