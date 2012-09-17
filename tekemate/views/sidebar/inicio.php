<div class="blocks">
<div class="twitterwg">
  <h2><span>El twitter</span></h2>
  <p><script src="http://widgets.twimg.com/j/2/widget.js"></script> 
    <script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 6000,
  width: 375,
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

<div class="recomendado">
  <h2><span>Nuestra mirada</span></h2>
  <h3><?php echo $recomendado->Nombre?></h3>
  <p>
    <iframe width="400" height="225" src="<?php echo $proveedor->Embed_URL?><?php echo $recomendado->Video_ID?>"><?php echo $recomendado->Nombre?></iframe>
  </p>
</div>
</div>