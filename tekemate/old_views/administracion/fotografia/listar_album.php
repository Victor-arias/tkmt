<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Fotografía - Álbumes</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/fotografia/agregar_album');?>">Agregar álbum</a></p>
	<table>
		<tr>
			<th>Nombre</th>
            <th>Editar</th>
		</tr>
		<?php foreach ($albumes as $a):?>
			<tr>
				<td><a href="<?php echo site_url('administracion/fotografia/ver_album/'.$a->ID_foto_album) ?>" title="Ver fotos del álbum <?php echo $a->Nombre;?>"><?php echo $a->Nombre;?></a></td>
                <td><?php echo anchor('administracion/fotografia/editar_album/'.$a->ID_foto_album, 'Editar álbum' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>	

