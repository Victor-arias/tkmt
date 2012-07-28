<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
	<title><?php echo $title; ?> - Admin Tekemate ID</title>
    <link href="<?php echo base_url();?>styles/admin.css" type="text/css" rel="stylesheet" />
    <link href="/favicon.ico" rel="shortcut icon" />
</head>
<body>
<div id="fixed">
	<?php $this->load->view('administracion/common/header');?>
    <div id="container">
    <?php 
	if ($this->ion_auth->logged_in())
		$this->load->view('administracion/common/leftmenu');
	else	
		$this->load->view('common/fullpage');
	?>
    </div>
    <?php $this->load->view('administracion/common/footer');?>
</div>
<p class="copyright">Tekemate Derechos reservados <?php echo date('Y');?></p>   
<link href="http://www.tekemate.com/styles/formalize.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
	<script src="<?php echo base_url();?>js/libs/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/libs/jquery.formalize.min.js" type="text/javascript"></script>
    <?php
if(isset($includes) and $includes)
	if(is_array($includes))
		foreach($includes as $include)
			echo $include;
	else
		echo $includes;
?>
</body>
</html>
<?php
/* End of file template.php */
/* Location: ./tekemate/views/administracion/template.php */