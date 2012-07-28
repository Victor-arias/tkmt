<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(array('mbanner', 'mmedia'));
	}
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		
	}//index
	
	public function obtener_imagenes(){
		if($this->input->is_ajax_request()){
			$Q = $this->mbanner->obtener();
			
			$this->load->helper('xml');
			$dom = xml_dom();
			$xml = xml_add_child($dom, 'imagenes');
			if($Q){
				//echo '<pre>'.print_r($Q).'</pre>';
				foreach($Q as $q){
						$imagen = xml_add_child($xml, 'imagen', $q->Nombre);	
						xml_add_attribute($imagen, 'url', $q->Url);
						xml_add_attribute($imagen, 'imagen', $q->mUrl);
						xml_add_attribute($imagen, 'ancho', $q->Ancho);
						xml_add_attribute($imagen, 'alto', $q->Alto);
				}
			}
			echo xml_print($dom, true);
		}else echo 'No es ajax';
	}//obtener_imagenes

	
}

/* End of file banner.php */
/* Location: ./application/controllers/banner.php */