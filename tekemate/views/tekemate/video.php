<div id="video" class="galeria">
    <div id="sidebar">
        <h2>Vídeo</h2>
        <ul>
          <?php foreach($categorias as $categoria): ?>
          <li<?php if(current_url() == site_url('video/'.$categoria->Alias)) echo ' class="active"';?>>
            <a href="<?php echo site_url('video/'.$categoria->Alias) ?>" title='<?php echo $categoria->Nombre?>'><?php echo $categoria->Nombre?></a>
          </li>
        <?php endforeach;?>
        </ul>
    </div>
    <div id="main">
        <h2><?php echo $categoria_actual->Nombre ?></h2>
        <?php if($categoria_actual->Descripcion): ?>
          <p class="descripcion"><?php echo $categoria_actual->Descripcion?></p>
        <?php endif;?>
        <div class="videos">
          <div class="inner">
        <?php foreach($videos as $video): ?>
            <div class="video">
              <!--<a class="iframe" href="<?php echo $video->Embed_URL;?>">
                <img src="<?php echo base_url().$video->Url ?>" alt="<?php echo $video->Texto_alternativo ?>" width="<?php echo $video->Ancho ?>" height="<?php echo $video->Alto ?>"/>
              </a>-->
              <iframe src="<?php echo $video->Embed_URL.$video->Video_ID?>" width="523" height="300"></iframe>
              <div class="detalles">
                <a href="#" class="prev">Atras</a><h3><?php echo $video->Nombre; ?></h3><a href="#" class="next">Adelante</a>
              </div>
            </div>
        <?php endforeach?>
          </div>
        </div>
    </div>
</div>