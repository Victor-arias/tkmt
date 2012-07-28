<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tekemate extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
	}
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		
	}//index
	
/*	public function lo_que_hacemos()
	{
		$tv['title'] = 'Lo que hacemos';
		$tv['content'] = $this->load->view('tekemate/lo_que_hacemos', false, true);
		$this->load->view('template', $tv);
	}//lo_que_hacemos
	
	public function fotografia()
	{
		$tv['title'] = 'Fotografía';
		$tv['content'] = $this->load->view('tekemate/fotografia', false, true);
		$tv['includes'][] = link_tag('styles/jquery.fancybox-1.3.4.css');
		$tv['includes'][] = script_tag('js/libs/jquery.fancybox-1.3.4.pack.js');
		$tv['includes'][] = script_tag('js/libs/jquery.jcarousel.min.js');
		$tv['includes'][] = script_tag('js/fotografia.js');
		$this->load->view('template', $tv);
	}//fotografía
	
	public function video()
	{
		//Inicializao la petición cURL
		$c = curl_init('http://vimeo.com/api/v2/tekemate/videos.json'/*'http://gdata.youtube.com/feeds/api/users/tekemateid/uploads?v=2&alt=json'*//*);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$datos = curl_exec($c); //Ejecuto la petición
		curl_close($c);
		$datos = json_decode($datos);
		$vc['videos'] = $datos;
		
		$tv['title'] = 'Video';
		$tv['content'] = $this->load->view('tekemate/video', $vc, true);
		$tv['includes'][] = link_tag('styles/jquery.fancybox-1.3.4.css');
		$tv['includes'][] = script_tag('js/libs/jquery.fancybox-1.3.4.pack.js');
		$tv['includes'][] = script_tag('js/libs/jquery.jcarousel.min.js');
		$tv['includes'][] = script_tag('js/video.js');
		$this->load->view('template', $tv);
	}//galeria
	
	public function contacto()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Correo', 'Correo', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('Mensaje', 'Mensaje', 'min_length[5]|required|xss_clean');
		$this->form_validation->set_rules('Validacion', 'Cuánto es 3+2?', 'exact_length[1]|callback_equal|required|xss_clean');
		
		if ($this->form_validation->run() == true){
			$Nombre = $this->input->post('Nombre');
			$Correo = $this->input->post('Correo');
			$Mensaje = $this->input->post('Mensaje');
			
			$this->load->library('email');
			$this->email->from($Correo, $Nombre);
			$this->email->to('info@tekemate.com');
			$this->email->subject('Mensaje del sitio web');
			$this->email->message($Mensaje);
			if($this->email->send()){
				$msg = 'Gracias por contactarnos!';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			}else{
				$msg = 'Ups!, algo ocurrió y no se pudo entregar el mensaje, por favor escríbanos a info@tekemate.com';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			}
		}
		
		$this->load->helper('form');
		
		$tv['messages']	= $messages;		
		$tv['title'] 	= 'Contáctenos';
		$tv['sidebar'] 	= $this->load->view('sidebar/contacto', false, true);
		$tv['content'] 	= $this->load->view('tekemate/contacto', false, true);
		$this->load->view('template', $tv);
	}//contacto
	
	public function _equal($number)
	{
		if ($number != 5)
		{
			$this->form_validation->set_message('_equal', 'La respuesta no es correcta');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}*/
}

/* End of file tekemate.php */
/* Location: ./application/controllers/administracion/tekemate.php */