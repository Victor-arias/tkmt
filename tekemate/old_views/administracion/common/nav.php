<div class="navigation">
    <ul>
    	<li>
        	<a href="<?php echo site_url('administracion/banner/listar');?>"><span>Banner</span></a>
            <ul>
                <li><a href="<?php echo site_url('administracion/banner/agregar');?>"><span>Agregar</span></a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo site_url('administracion/recomendado');?>"><span>Recomendado</span></a>
            <ul>
                <li><a href="<?php echo site_url('administracion/recomendado/agregar');?>"><span>Agregar</span></a></li>
            </ul>
        </li>
       <!-- <li>
            <a href="<?php echo site_url('administracion/servicios');?>"><span>Servicios</span></a>
            <ul>
                <li><a href="<?php echo site_url('administracion/servicios/agregar');?>"><span>Agregar</span></a></li>
            </ul>
        </li>-->
        <li>
            <a href="<?php echo site_url('administracion/fotografia');?>"><span>Fotografía</span></a>
            <ul>
                <!--<li><a href="<?php echo site_url('administracion/servicios/agregar');?>"><span>Agregar</span></a></li>-->
            </ul>
        </li>
       <li>
            <a href="<?php echo site_url('administracion/categoria_video');?>"><span>Vídeo</span></a>
            <ul>
                <li><a href="<?php echo site_url('administracion/categoria_video');?>"><span>Listar categorías</span></a></li>
                <li><a href="<?php echo site_url('administracion/categoria_video/agregar');?>"><span>Agregar categoría</span></a></li>
                <li><a href="<?php echo site_url('administracion/video');?>"><span>Listar vídeos</span></a></li>
                <li><a href="<?php echo site_url('administracion/video/agregar');?>"><span>Agregar vídeo</span></a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo site_url('administracion/usuario');?>"><span>Usuarios</span></a>
            <ul>
                <li><a href="<?php echo site_url('administracion/usuario/crear_usuario');?>"><span>Agregar</span></a></li>
            </ul>
        </li>
        <li>
        	<a href="<?php echo site_url('administracion/contacto/editar');?>"><span>Contácto</span></a>
        </li>
    </ul>        
</div>
<?php 
/* End of file nav.php */
/* Location: ./tekemate/views/administracion/common/nav.php */