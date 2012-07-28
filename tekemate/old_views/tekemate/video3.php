<h2>Vídeo</h2>
<div class="categorias">
  <?php foreach($categorias as $c=>$videos):?>
  <div class="categoria">
    <h3><?php echo $c;?></h3>
    <div class="videos">
      <?php foreach($videos as $v):?>
      <div class="video"> <a class="iframe" href="<?php echo $v->Embed_URL.$v->Video_ID;?>"><img src="<?php echo $v->Url;?>" width="<?php echo $v->Ancho;?>" height="<?php echo $v->Alto;?>" alt="<?php echo $v->Nombre;?>"/></a>
        <h4><?php echo $v->Nombre;?></h4>
      </div>
      <?php endforeach;?>
    </div>
  </div>
  <?php endforeach;?>
</div>
