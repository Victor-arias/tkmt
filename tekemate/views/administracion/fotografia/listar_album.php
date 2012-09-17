<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Fotografía - Álbumes</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/fotografia/agregar_album');?>">Agregar álbum</a></p>
	<table>
		<tr>
			<th>Nombre</th>
            <!--<th>Editar</th>-->
            <th>Eliminar</th>
		</tr>
		<?php if($albumes):
			foreach ($albumes as $a):?>
			<tr>
				<td><a href="<?php echo site_url('administracion/fotografia/listar/'.$a->ID_foto_album) ?>" title="Ver fotos del álbum <?php echo $a->Nombre;?>"><?php echo $a->Nombre;?></a></td>
                <!--<td><?php echo anchor('administracion/fotografia/editar_album/'.$a->ID_foto_album, 'Editar álbum' );?></td>-->
                <td><?php echo anchor('administracion/fotografia/eliminar_album/'.$a->ID_foto_album, 'Eliminar' );?></td>
			</tr>
		<?php endforeach;?>
		<?php else:?>
			<tr>
				<td>No hay albumes para mostrar</td>
                
			</tr>
		<?php endif;?>
	</table>
</div>	

