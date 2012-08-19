<div id="video" class="galeria">
    <div id="sidebar">
        <h2>Vídeo</h2>
        <ul>
          <li><a href='<?php echo site_url('video/institucionales') ?>' title='Institucionales'>Institucionales</a></li>
          <li><a href='<?php echo site_url('video/musicales') ?>' title='Musicales'>Musicales</a></li>
          <li><a href='<?php echo site_url('video/comerciales') ?>' title='Comerciales'>Comerciales</a></li>
          <li><a href='<?php echo site_url('video/argumentales') ?>' title='Argumentales'>Argumentales</a></li>
          <li><a href='<?php echo site_url('video/comunicacion-interna') ?>' title='Comunicación interna'>Comunicación interna</a></li>
          <li><a href='<?php echo site_url('video/post-produccion') ?>' title='Post producción'>Post producción</a></li>
        </ul>
    </div>
    <div id="main">
      <?php foreach($videos as $c):?>
  <div class="categoria">
      <h2><?php echo $c['list']->{'$t'} ?></h2>
        <?php if($c['summary']->{'$t'} != ''):?> <p><?php echo $c['summary']->{'$t'} ?></p> <?php endif?>
        <div class="videos">
      <?php foreach($c['content'] as $v): ?>
            <div class="video">
            <a class="iframe" href="<?php echo $v['url'];?>"><img src="<?php echo $v['thumbnail']->url ?>" alt="<?php echo $v['title']->{'$t'} ?>" width="<?php echo $v['thumbnail']->width ?>" height="<?php echo $v['thumbnail']->height ?>"/></a>
            <h3><?php echo $v['title']->{'$t'} ?></h3>
            </div>
      <?php endforeach?>
        </div>
    </div>
<?php endforeach?>
      
      <?php //foreach($c['content'] as $v): ?>
            <!--<div class="video">
              <iframe width="490" height="276" src="<?php //echo $v['url'];?>" frameborder="0" allowfullscreen></iframe>
            <p><?php //echo $v['title']->{'$t'} ?></p>
            </div>-->
      <?php //endforeach?>

    </div>
</div>