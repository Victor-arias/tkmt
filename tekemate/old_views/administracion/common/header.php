<div id="header">
    <h1>
        <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url();?>images/logo_admin.png" alt="Logo Tekemate imagen digital" width="274" height="72" /></a>
    </h1>
    <?php if ($this->ion_auth->logged_in()): ?>
    <div id="user">Hola <strong><?php echo $this->session->userdata('username');?></strong>
        <div id="user_menu">
            <ul>
                <li><a href="<?php echo site_url('usuario/editar/'.$this->session->userdata('Id_usuario'));?>"><span>Tu perfil</span></a></li>
                <li><a href="<?php echo site_url('administracion/usuario/cerrar_sesion');?>"><span>Salir</span></a></li>
            </ul>
        </div>
    </div>
    <?php endif;?>
</div>
<?php
/* End of file header.php */
/* Location: ./tekemate/views/administracion/common/header.php */