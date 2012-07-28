<nav>
    <ul>
        <li<?php if(current_url() == site_url()) echo ' class="active"';?>>
            <a href="<?php echo site_url();?>"><span>Inicio</span></a>
        </li>
        <li<?php if(current_url() == site_url('lo-que-hacemos')) echo ' class="active"';?>>
            <a href="<?php echo site_url('lo-que-hacemos');?>"><span>Lo que hacemos</span></a>
        </li>
        <li<?php if(current_url() == site_url('fotografia')) echo ' class="active"';?>>
            <a href="<?php echo site_url('fotografia');?>"><span>Fotografía</span></a>
        </li>
        <li<?php if(current_url() == site_url('video')) echo ' class="active"';?>>
            <a href="<?php echo site_url('video');?>"><span>Vídeo</span></a>
        </li>
        <li<?php if(current_url() == site_url('contacto')) echo ' class="active"';?>>
            <a href="<?php echo site_url('contacto');?>"><span>Contacto</span></a>
        </li>
    </ul>        
</nav>
<?php 
/* End of file nav.php */
/* Location: ./tekemate/views/common/nav.php */