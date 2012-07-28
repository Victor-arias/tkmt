<html>
<body>
<h1>Restaurar clave para <?php echo $identity;?></h1>
<p>Por favor haga clic en el siguiente enlace para <?php echo anchor('administracion/usuario/reset_password/'. $forgotten_password_code, 'restaurar su clave');?>.</p>
</body>
</html>