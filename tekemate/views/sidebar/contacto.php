<?php foreach($contacto as $c):?>
<div id="hcard" class="vcard">
    <span class="fn"><?php echo $c->Nombre?></span>
	<span><?php echo $c->Cargo?></span>
    <div class="tel"><?php echo $c->Celular?></div>
    <a class="email" href="mailto:<?php echo $c->Email?>"><?php echo $c->Email?></a>
	<a class="email" href="mailto:<?php echo $c->Email_personal?>"><?php echo $c->Email_personal?></a>
</div>
<?php endforeach ?>