<?php /*
header("Cache-Control: must-revalidate");
$offset = 60 * 60 * 24 * 3;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr);*/

if(!isset($sidebar)) $cols = 'fullpage';

?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="utf-8">
    <meta name="keywords" content="<?php echo $keywords;?>" />
    <meta name="description" content="<?php echo $description;?>" />
    <meta property="og:title" content="<?php echo $title;?> - Tekemate Producción Audiovisual" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo current_url();?>" />
    <meta property="og:image" content="<?php echo base_url();?>images/logo_tekemate.png" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width">
	<title><?php echo $title; ?> - Tekemate Producción Audiovisual</title>
    <link href="<?php echo base_url();?>styles/style.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url();?>styles/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
    <link href="/favicon.ico" rel="shortcut icon" />
</head>
<body>
<div id="topbar">
	<div class="fixed">
	<div class="contact">
		<span class="email">tekemate@tekemate.com</span>
    	<span class="tel">Teléfono: (+057) 301 256 3769</span>
    </div>
	<?php $this->load->view('common/social');?>
    </div>
</div>
<div id="fixed">
	<?php $this->load->view('common/header');?>
    <div id="container" class="wrapper clearfix">
    <?php $this->load->view('common/'.$cols);?>
    </div>
</div>
<?php $this->load->view('common/footer');?>
<p class="copyright fixed">Diseño: <a href="#">Whiteline</a> - Desarrollo: <a href="/">Tekemate</a></p>   
<!--[if lt IE 9]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url();?>js/libs/jquery-1.6.4.min.js"><\/script>')</script>
	<script src="<?php echo base_url();?>js/libs/jquery.plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
	$(document).ready(function() {
//		alert(navigator.appName);
		$('#header h1 a').jEye({wEye:214,hEye:154,wPupil:34,hPupil:36});
		/*$('#banner').before('<div class="banner_nav">').cycle({fx: 'fade', random: 1, speed: 10000, speedIn:1500, speedOut:1500, delay:5000, timeout:1500, startingSlide: Math.random(2), pager: '.banner_nav'});*/
	});
	</script>
    <?php
if(isset($includes) and $includes)
	if(is_array($includes))
		foreach($includes as $include)
			echo $include;
	else
		echo $includes;
?>
<script type="text/javascript">
  var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-24776889-1']); _gaq.push(['_trackPageview']); (function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'es-419'}
</script>
</body>
</html>
<?php
/* End of file template.php */
/* Location: ./tekemate/views/template.php */