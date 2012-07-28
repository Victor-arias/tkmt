<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recomendado extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model('mrecomendado');
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
				
		$cv['recomendados'] = $this->mrecomendado->obtener();
			
		$cv['messages']		= $messages;
		
		$tv['title'] = 'Recomendado';
		//$tv['sidebar'] = $this->load->view('sidebar/inicio', false, true);
		$tv['content'] = $this->load->view('administracion/recomendado/listar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function agregar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		//if($this->ion_auth->errors()) $messages[] = $this->ion_auth->errors();
		
		$this->load->model('mproveedor_video');
		
			
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Video_ID', 'Video_ID', 'required');
		
		if ($this->form_validation->run() == true){
			$Publicado = $this->input->post('Publicado');
			$Video_ID = $this->input->post('Video_ID');
			
			$this->mrecomendado->Video_ID = $Video_ID;
			if(!$vi = $this->mrecomendado->obtener_uno()){
				
				$this->mrecomendado->Nombre = $this->input->post('Nombre');
				$this->mrecomendado->ID_proveedor_video = $this->input->post('Proveedor');
				$this->mrecomendado->Video_ID = $Video_ID;
				$this->mrecomendado->Fecha_publicacion = date('Y-m-d'); 
				$this->mrecomendado->Publicado = $Publicado;
				$this->mrecomendado->Activo = 1;
				
				$q = $this->mrecomendado->agregar();
				if($q){
					if($Publicado){
						$this->mrecomendado->despublicar($q);
					}
					//redirect them back to the admin page
					$msg = 'Recomendado agregado con éxito';
					$tipo = 'exito';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);
					redirect("administracion/recomendado/listar", 'refresh');
				}else{
					$msg = 'Ocurrió un error agregando el recomendado';
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);	
				}
			}else if($Publicado){
				$this->mrecomendado->despublicar($vi->ID_recomendado);
				$this->mrecomendado->Video_ID = $Video_ID;
				$this->mrecomendado->Publicado = $Publicado;
				$this->mrecomendado->Activo = 1;
				$q = $this->mrecomendado->editar();
				$msg = 'El recomendado ya se encontraba en la base de datos, se publicí con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/recomendado/listar", 'refresh');
			}else{
				$msg = 'El recomendado ya se encuentra en la base de datos';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);		
			}
			
		}
		
		$this->load->model(array('mrecomendado', 'mproveedor_video'));
		
		foreach($this->mproveedor_video->obtener() as $proveedor)
			$cv['Proveedor'][$proveedor->ID_proveedor_video] = $proveedor->Nombre;
		
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$tv['title'] = 'Agregar recomendado';
		
		$tv['content'] = $this->load->view('administracion/recomendado/agregar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}//agregar
	
	public function editar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		//if($this->ion_auth->errors()) $messages[] = $this->ion_auth->errors();
		
		$this->load->model('mproveedor_video');

		$ID_recomendado = ($this->input->post('ID_recomendado'))?$this->input->post('ID_recomendado'):$this->uri->segment('4');
		
		$this->mrecomendado->ID_recomendado = $ID_recomendado;
		$recomendado = $this->mrecomendado->obtener_uno();
		
			
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Video_ID', 'Video_ID', 'required');
		
		if ($this->form_validation->run() == true){
			$Publicado = $this->input->post('Publicado');
			($this->input->post('Activo'))?$Activo = 1:$Activo = 0;
			$Video_ID = $this->input->post('Video_ID');
			
			$this->mrecomendado->Video_ID = $Video_ID;
			if($vi = $this->mrecomendado->obtener_uno()){
				
				$this->mrecomendado->ID_recomendado = $this->input->post('ID_recomendado');
				$this->mrecomendado->Nombre = $this->input->post('Nombre');
				$this->mrecomendado->ID_proveedor_video = $this->input->post('Proveedor');
				$this->mrecomendado->Video_ID = $Video_ID;
				$this->mrecomendado->Publicado = $Publicado;
				$this->mrecomendado->Activo = $Activo;
				
				$q = $this->mrecomendado->editar();
				if($q){
					if($Publicado){
						$this->mrecomendado->despublicar($q);
					}
					//redirect them back to the admin page
					$msg = 'Recomendado modificado con éxito';
					$tipo = 'exito';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);
					redirect("administracion/recomendado/listar", 'refresh');
				}else{
					$msg = 'Ocurrió un error modificando el recomendado';
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);	
				}
			}else{
				$msg = 'El recomendado no se encuentra en la base de datos';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);		
			}
			
		}
				
		foreach($this->mproveedor_video->obtener() as $proveedor)
			$cv['Proveedor'][$proveedor->ID_proveedor_video] = $proveedor->Nombre;
		
		$cv['r'] = $recomendado;
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$tv['includes'][] = script_tag('js/editar.js');
		$tv['title'] = 'Editar recomendado';
		
		$tv['content'] = $this->load->view('administracion/recomendado/editar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function eliminar(){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_recomendado = ($this->input->post('ID_recomendado'))?$this->input->post('ID_recomendado'):$this->uri->segment('4');
		
	 	/*if(!$this->input->is_ajax_request()){
			//Si no viene de JS, confirmar la eliminación del elemento
			$msg = 'Seguro que realmente desea eliminar este recomendado?';
			$tipo = 'exito';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/recomendado/editar/".$ID_recomendado, 'refresh');
		}*/
		
		if($ID_recomendado){
			$this->mrecomendado->ID_recomendado = $ID_recomendado;
			$q = $this->mrecomendado->delete();
			if($q){
				$msg = 'Se elimino correctamente el recomendado';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			}else{
				$msg = 'No se pudo eliminar el recomendado';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);	
			}
		}else{
			$msg = 'No se indicó el recomendado a eliminar';
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
		}
		
		$this->session->set_flashdata('messages', $messages);
		redirect("administracion/recomendado/listar", 'refresh');
		
	}
		
}

/* End of file recomendado.php */
/* Location: ./application/controllers/administracion/recomendado.php */