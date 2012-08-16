<nav>
    <ul>
        <li<?php if(current_url() == site_url()) echo ' class="active"';?>>
            <a href="<?php echo site_url();?>"><span>Inicio</span></a>
        </li>
        <li<?php if(current_url() == site_url('asi-somos')) echo ' class="active"';?>>
            <a href="<?php echo site_url('asi-somos');?>"><span>Así somos</span></a>
        </li>
        <li<?php if(current_url() == site_url('servicios')) echo ' class="active"';?>>
            <a href="<?php echo site_url('servicios');?>"><span>Servicios</span></a>
        </li>
        <li<?php if(current_url() == site_url('fotografia') || current_url() == site_url('video')) echo ' class="active"';?>>
            <a href="<?php echo site_url('fotografia');?>"><span>Galería</span></a>
            <ul class="submenu">
                <li><a href="<?php echo site_url('fotografia');?>"><span>Fotografía</span></a></li>
                <li><a href="<?php echo site_url('video');?>"><span>Vídeo</span></a></li>
            </ul>
        </li>
        <li<?php if(current_url() == site_url('contacto')) echo ' class="active"';?>>
            <a href="<?php echo site_url('contacto');?>"><span>Contacto</span></a>
        </li>
    </ul>        
</nav>
<?php 
/* End of file nav.php */
/* Location: ./tekemate/views/common/nav.php */