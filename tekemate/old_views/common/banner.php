<div id="banner">
	<?php 
	//$this->load->model('mbanner');
	$this->mbanner->Publicado = 1;
	$Q = $this->mbanner->obtener();
	if($Q)
		foreach($Q as $q)
			echo '<a href="'.$q->Url.'"><img src="'.$q->mUrl.'" alt="'.$q->Nombre.'" title="'.$q->Nombre.'" width="'.$q->Ancho.'" height="'.$q->Alto.'" /></a>';
	?>
</div>
<?php 
/* End of file banner.php */
/* Location: ./tekemate/views/common/banner.php */