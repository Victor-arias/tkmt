<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_video extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model(array('mcategoria_video', 'mvideo', 'mmedia'));
	}
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->listar();	
	}//index
	
	public function listar()
	{
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$cv['messages']		= $messages;
		$cv['categorias'] 	= $this->mcategoria_video->obtener();
		
		$tv['title'] = 'Categorías (Vídeos)';

		$tv['content'] = $this->load->view('administracion/categoria_video/listar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function agregar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Descripcion', 'Descripción', 'xss_clean');
		$this->form_validation->set_rules('Orden', 'Orden', 'callback__reordenar');
		
		if ($this->form_validation->run() == true){
			$this->mcategoria_video->Nombre 		= $this->input->post('Nombre');
			$this->mcategoria_video->Alias 		    = url_title($this->input->post('Nombre'), 'dash', TRUE);
			$this->mcategoria_video->Descripcion    = $this->input->post('Descripcion');
			$this->mcategoria_video->Orden    		= $this->input->post('Orden');
			$this->mcategoria_video->Activo 		= ($this->input->post('Activo'))?1:0;

			$q = $this->mcategoria_video->agregar();
			if($q){
				$msg = 'Categoría agregada con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/categoria_video/listar", 'refresh');
			}else{
				$msg = 'Ocurrió un error agregando la categoría';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
			
		}
		
		$categorias = $this->mcategoria_video->count();
		$Orden[1] = 'Primero';
		for($i=2;$i<$categorias+1;$i++){
			$Orden[$i] = $i;
		}
		$Orden[$i] = 'Último';		
		
		$this->load->helper('form');
		
		$cv['messages']	= $messages;
		
		$cv['Orden']	= $Orden;
		
		$tv['title'] = 'Agregar categoría (vídeo)';
		
		$tv['content'] = $this->load->view('administracion/categoria_video/agregar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}//agregar
	
	public function ver(){
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_categoria_video = ($this->input->post('ID_categoria_video'))?$this->input->post('ID_categoria_video'):$this->uri->segment('4');
		$this->mcategoria_video->ID_categoria_video= $ID_categoria_video;
		$categoria_video = $this->mcategoria_video->obtener_uno();
		
		$this->mvideo->ID_categoria_video = $ID_categoria_video;
		$videos = $this->mvideo->obtener();
		
		$cv['messages']	= $messages;
		$cv['cv']		= $categoria_video;
		$cv['videos']	= $videos;
		
		$tv['title'] = 'Ver categoría ' .$categoria_video->Nombre. '(vídeo)';
		
		$tv['content'] = $this->load->view('administracion/categoria_video/ver', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	//Editar
	public function editar(){
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_categoria_video = ($this->input->post('ID_categoria_video'))?$this->input->post('ID_categoria_video'):$this->uri->segment('4');
		$this->mcategoria_video->ID_categoria_video= $ID_categoria_video;
		$categoria_video = $this->mcategoria_video->obtener_uno();
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Alias', 'Alias', 'url_title|is_unique[Categoria_video.Alias]|xss_clean');
		$this->form_validation->set_rules('Descripcion', 'Descripción', 'xss_clean');
		$this->form_validation->set_rules('Orden', 'Orden', "callback__reordenar[$ID_categoria_video]");
		
		if($this->form_validation->run()){
			$this->mcategoria_video->Nombre 	 = $this->input->post('Nombre');
			$this->mcategoria_video->Alias 		 = ($this->input->post('Alias'))?$this->input->post('Alias'):url_title($this->input->post('Nombre'), 'dash', TRUE);
			$this->mcategoria_video->Descripcion = $this->input->post('Descripcion');
			$this->mcategoria_video->Orden    	 = $this->input->post('Orden');
			$this->mcategoria_video->Activo = ($this->input->post('Activo'))?1:0;
			
			$q = $this->mcategoria_video->editar();
			if($q){
				$msg = 'Categoría modificada con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/categoria_video/listar", 'refresh');
			}else{
				$msg = 'Ocurrió un error modificando la categoría (vídeo)';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
		}
		
		$cv['c'] = $categoria_video;
		$this->load->helper('form');
		
		$this->mcategoria_video->clear();
		$categorias = $this->mcategoria_video->count();
		$Orden[1] = 'Primero';
		for($i=2;$i<$categorias+1;$i++){
			$Orden[$i] = $i;
		}
		$Orden[$i] = 'Último';		
		
		$cv['messages']	= $messages;
		
		$cv['Orden']	= $Orden;
		
		$tv['includes'][] = script_tag('js/editar.js');
		$tv['title'] = 'Editar categoría (Vídeo)';
		
		$tv['content'] = $this->load->view('administracion/categoria_video/editar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function eliminar(){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');

		$ID_categoria_video = ($this->input->post('ID_categoria_video'))?$this->input->post('ID_categoria_video'):$this->uri->segment('4');
		
	 	if($ID_categoria_video){
		
			$this->mcategoria_video->ID_categoria_video = $ID_categoria_video;
			
			$q = $this->mcategoria_video->delete();
			
			if($q){
				$msg = 'Se elimino correctamente la imagen';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			}else{
				$msg = 'No se pudo eliminar la imagen';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);	
			}
		}else{
			$msg = 'No se indicó la imagen a eliminar';
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
		}
		
		$this->session->set_flashdata('messages', $messages);
		redirect("administracion/categoria_video/listar", 'refresh');
		
	}
	
	public function _reordenar($orden, $ID_categoria_video = 0){
		if($ID_categoria_video != 0) $this->mcategoria_video->ID_categoria_video;
		$this->mcategoria_video->reordenar($orden);
		return true;	
	}
	
	/*Metodo para eliminar acentos de una cadena*/
	private function _limpiarAcentos($s){
		$s = ereg_replace("[áàâãª]","a",$s);
		$s = ereg_replace("[ÁÀÂÃ]","A",$s);
		$s = ereg_replace("[ÍÌÎ]","I",$s);
		$s = ereg_replace("[íìî]","i",$s);
		$s = ereg_replace("[éèê]","e",$s);
		$s = ereg_replace("[ÉÈÊ]","E",$s);
		$s = ereg_replace("[óòôõº]","o",$s);
		$s = ereg_replace("[ÓÒÔÕ]","O",$s);
		$s = ereg_replace("[úùû]","u",$s);
		$s = ereg_replace("[ÚÙÛ]","U",$s);
		$s = ereg_replace("[Ññ]","n",$s);
		$s = ereg_replace("[.]","_",$s);
		$s = ereg_replace("[/()]","-",$s);
		$s = ereg_replace("[ ]","_",$s);
		return $s;
	} 
	
}

/* End of file categoria_video.php */
/* Location: ./application/controllers/administracion/categoria_video.php */