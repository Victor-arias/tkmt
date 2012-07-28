<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model('mcontacto');
//		$this->output->enable_profiler();
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
		else $this->editar();	
	}//index
	
	//Editar
	function editar(){
				
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
//		$ID_contacto= ($this->input->post('ID_contacto'))?$this->input->post('ID_contacto'):$this->uri->segment('4');
		$this->mcontacto->ID_contacto = 1;
		$contacto = $this->mcontacto->obtener_uno();
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Cargo', 'Cargo', 'required|xss_clean');
		$this->form_validation->set_rules('Celular', 'Celular', 'required|xss_clean');
		$this->form_validation->set_rules('Email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('Email_personal', 'Email_personal', 'valid_email|xss_clean');

		if($this->form_validation->run()){
			$Nombre = $this->input->post('Nombre');
			$this->mcontacto->Nombre = $Nombre;
			$this->mcontacto->Cargo = $this->input->post('Cargo');	
			$this->mcontacto->Celular = $this->input->post('Celular');
			$this->mcontacto->Email = $this->input->post('Email');
			$this->mcontacto->Email_personal = $this->input->post('Email_personal');
			$this->mcontacto->Activo = 1;
				
			
			$q = $this->mcontacto->editar();
			if($q){
				$msg = 'Contacto modificado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/contacto/editar", 'refresh');
			}else{
				$msg = 'Ocurrió un error modificando el contacto';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
		}
		
		$cv['c'] = $contacto;
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$tv['title'] = 'Editar contacto';
		
		$tv['content'] = $this->load->view('administracion/contacto/editar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
}

/* End of file contacto.php */
/* Location: ./application/controllers/administracion/contacto.php */