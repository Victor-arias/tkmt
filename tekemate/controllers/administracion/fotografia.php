<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fotografia extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model(array('mfoto_album', 'mfoto'));
	}
	
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		if (!$this->ion_auth->logged_in()) 
			redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin())
			redirect($this->config->item('base_url'), 'refresh');
		else $this->listar_album();	;
	}//index
	
	public function listar_album()
	{
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$cv['messages']		= $messages;
		$cv['albumes'] = $this->mfoto_album->obtener();
		
		$tv['title'] = 'Fotografía - Albumes';
		
		$tv['content'] = $this->load->view('administracion/fotografia/listar_album', $cv, true);
		$this->load->view('administracion/template', $tv);
	}//listar_album
	
	public function agregar_album()
	{
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Orden', 'Orden', 'callback__reordenar');
		
		if ($this->form_validation->run() == true){
			$rutaFotos = 'fotos/galeria/';
			$Carpeta = url_title($this->input->post('Nombre'), 'dash', TRUE);
			if(is_dir($rutaFotos.$Carpeta)){
				$Carpeta .= rand(rand(0,20), rand(20, 100));
			}
			mkdir($rutaFotos.$Carpeta);
			$this->mfoto_album->Nombre 		= $this->input->post('Nombre');
			$this->mfoto_album->Alias	    = $Carpeta;
			$this->mfoto_album->Carpeta     = $Carpeta;
			$this->mfoto_album->Orden    	= $this->input->post('Orden');
			$this->mfoto_album->Activo 		= ($this->input->post('Activo'))?1:0;

			$q = $this->mfoto_album->agregar();
			if($q){
				$msg = 'Álbum agregado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/fotografia/listar_album", 'refresh');
			}else{
				$msg = 'Ocurrió un error agregando el álbum';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
			
		}
		
		$albumes = $this->mfoto_album->count();
		$Orden[1] = 'Primero';
		for($i=2;$i<$albumes+1;$i++){
			$Orden[$i] = $i;
		}
		$Orden[$i] = 'Último';		
		
		$this->load->helper('form');
		
		$cv['messages']	= $messages;
		
		$cv['Orden']	= $Orden;
		
		$cv['album'] = $this->mfoto_album->obtener_uno();
		
		$tv['title'] = 'Fotografía - Agregar álbum';
		
		$tv['content'] = $this->load->view('administracion/fotografia/agregar_album', $cv, true);
		$this->load->view('administracion/template', $tv);

	}//agregar_album
	
	//Editar
	public function editar_album(){
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_foto_album = ($this->input->post('ID_foto_album'))?$this->input->post('ID_foto_album'):$this->uri->segment('4');
		$this->mfoto_album->ID_foto_album = $ID_foto_album;
		$foto_album = $this->mfoto_album->obtener_uno();
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Alias', 'Alias', 'url_title|is_unique[Foto_album.Alias]|xss_clean');
		$this->form_validation->set_rules('Orden', 'Orden', "callback__reordenar[$ID_foto_album]");
		
		if($this->form_validation->run()){
			$this->mfoto_album->Nombre 	 = $this->input->post('Nombre');
			$this->mfoto_album->Alias 	 = ($this->input->post('Alias'))?$this->input->post('Alias'):url_title($this->input->post('Nombre'), 'dash', TRUE);
			$this->mfoto_album->Orden    = $this->input->post('Orden');
			$this->mfoto_album->Activo 	 = ($this->input->post('Activo'))?1:0;
			
			$q = $this->mfoto_album->editar();
			if($q){
				$msg = 'Álbum modificado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/fotografia/listar_album", 'refresh');
			}else{
				$msg = 'Ocurrió un error modificando el álbum';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
		}
		
		$cv['a'] = $foto_album;
		$this->load->helper('form');
		
		$this->mfoto_album->clear();
		$albumes = $this->mfoto_album->count();
		$Orden[1] = 'Primero';
		for($i=2;$i<$albumes+1;$i++){
			$Orden[$i] = $i;
		}
		$Orden[$i] = 'Último';		
		
		$cv['messages']	= $messages;
		
		$cv['Orden']	= $Orden;
		
		$tv['includes'][] = script_tag('js/editar.js');
		$tv['title'] = 'Editar álbum de fotografías';
		
		$tv['content'] = $this->load->view('administracion/fotografia/editar_album', $cv, true);
		$this->load->view('administracion/template', $tv);
	}//editar_album
	
	public function _reordenar($orden, $ID_foto_album = 0){
		if($ID_foto_album != 0) $this->mfoto_album->ID_foto_album;
		$this->mfoto_album->reordenar($orden);
		return true;	
	}

}

/* End of file tekemate.php */
/* Location: ./application/controllers/administracion/fotografia/tekemate.php */