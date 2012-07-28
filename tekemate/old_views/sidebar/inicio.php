<div class="recomendado">
<h2>Recomendado de la semana</h2>
<h3><?php echo $recomendado->Nombre?></h3>
<p><iframe width="500" height="280" src="<?php echo $proveedor->Embed_URL?><?php echo $recomendado->Video_ID?>"><?php echo $recomendado->Nombre?></iframe></p>
</div>
<div class="twitterwg">
<h2><img src="<?php echo base_url()?>images/twitter.png" alt="Twitter" width="188" height="44" /></h2>
<p><script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 6000,
  width: 310,
  height: 300,
  theme: {
    shell: {
      background: '#ffffff',
      color: '#404040'
    },
    tweets: {
      background: '#ffffff',
      color: '#4d4d4d',
      links: '#5dc2cf'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: true,
    behavior: 'all'
  }
}).render().setUser('Tekemate').start();
</script>
<noscript>
<a href="http://www.twitter.com/tekemate">Síguenos en twitter</a>
</noscript>
</p>
</div>