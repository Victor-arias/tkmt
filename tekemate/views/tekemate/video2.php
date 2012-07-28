<h2>Vídeo</h2>
<div class="categorias">
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
</div>