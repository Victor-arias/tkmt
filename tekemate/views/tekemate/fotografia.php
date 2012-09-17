<div id="fotografia" class="galeria">
    <div id="sidebar">
        <h2>Fotografía</h2>
        <ul>
          <?php foreach($albumes as $album): ?>
          <li<?php if(current_url() == site_url('fotografia/'.$album->Alias)) echo ' class="active"';?>>
            <a href="<?php echo site_url('fotografia/' . $album->Alias) ?>" title='<?php echo $album->Nombre?>'><?php echo $album->Nombre?></a>
          </li>
        <?php endforeach?>
        </ul>
    </div>
    <div id="main">
      <h2><?php echo $album_actual->Nombre ?></h2>
        <div class="fotos">
          <div class="inner">
        <?php foreach($fotos as $foto): ?>
            <div class="foto">
              <img src="<?php echo base_url()?>fotos/galeria/<?php echo $foto->Alias?>/<?php echo $foto->Foto?>.jpg"></iframe>
              <div class="detalles">
                <a href="#" class="prev">Atras</a><h3><?php echo $foto->Nombre; ?></h3><a href="#" class="next">Adelante</a>
              </div>
            </div>
        <?php endforeach?>
          </div>
        </div>
    </div>
</div>