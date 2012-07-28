<html>
<body>
<h1>Active su cuenta para <?php echo $identity;?></h1>
<p>Por favor haga clic en el siguiente enlace para <?php echo anchor('administracion/usuario/activate/'. $id .'/'. $activation, 'activar tu cuenta');?>.</p>
</body>
</html>