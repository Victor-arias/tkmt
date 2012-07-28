<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Banner</h2>
<div id="contenido">
	<p><a class="agregar" href="<?php echo site_url('administracion/banner/agregar_imagen');?>">Agregar imagen al banner</a></p>
	<table>
		<tr>
			<th>Miniatura</th>
            <th>Nombre</th>
            <th>Url</th>
            <th>Agregado</th>
            <th>Publicado</th>
            <th>Editar</th>
		</tr>
		<?php
		 foreach ($banners as $b):?>
			<tr>
            	<td><a href="<?php echo base_url().$b->mUrl ?>" class="fancybox"><img src="<?php echo base_url().$b->tUrl?>" width="<?php echo $b->tAncho?>" height="<?php echo $b->tAlto?>" alt="<?php echo $b->tTexto_alternativo?>"/></a></td>
				<td><?php echo $b->Nombre?></td>
                <td><a href="<?php echo $b->Url?>" /><?php echo $b->Url?></a></td>
                <td><?php echo $b->Agregado?></td>
                <td><?php echo $b->Publicado?></td>
                <td><?php echo anchor('administracion/banner/editar/'.$b->ID_banner, 'Editar' );?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>	

