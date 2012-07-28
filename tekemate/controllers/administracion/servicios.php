<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model('mservicio');
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
		else $this->listar();	
	}//index
	
	public function listar()
	{
		if (!$this->ion_auth->logged_in()) 
			redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin())
			redirect($this->config->item('base_url'), 'refresh');
			
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$cv['messages']		= $messages;
		$cv['servicios'] = $this->mservicio->obtener();
		
		$tv['title'] = 'Servicios';
		//$tv['sidebar'] = $this->load->view('sidebar/inicio', false, true);
		$tv['content'] = $this->load->view('administracion/servicio/listar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function agregar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Intro', 'Intro', 'required|xss_clean');
		$this->form_validation->set_rules('Descripcion', 'Descripción', 'required|xss_clean');
		
		if ($this->form_validation->run() == true){
			$Nombre = $this->input->post('Nombre');
			$this->mservicio->Nombre = $Nombre;
			$this->mservicio->Intro = $this->input->post('Intro');	
			$this->mservicio->Descripcion = $this->input->post('Descripcion');
			$this->mservicio->Activo = $this->input->post('Activo');
			
			/**************FOTO****************/
			$rutaImagenes = 'fotos/servicios/';
			
			$this->load->library('upload');
			$config['upload_path'] = $rutaImagenes;
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	   = '5000';
			$this->upload->initialize($config);

			if(!$this->upload->do_upload('Imagen')){
				$img = $thumb ='';
				$msg = $this->upload->display_errors();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				//log_message('error', 'C: Llanta->agregar(): ' . $msg);
			}else{//upload
				$imagen = $this->upload->data();
				if($imagen['file_name']){
					$nuevoNombre = $this->_limpiarAcentos($Nombre).$imagen['file_ext'];
					$i = 1; 
					while(file_exists($rutaImagenes.$nuevoNombre)){
						$nuevoNombre = $this->_limpiarAcentos($Nombre).$i.$imagen['file_ext'];
						$i++;
					}
					$img = $nuevoNombre;
					rename($rutaImagenes.$imagen['file_name'], $rutaImagenes.$nuevoNombre);
					$thumb = $this->_limpiarAcentos($Nombre).'_thumb'.$imagen['file_ext'];
					$i = 0;
					while(file_exists($rutaImagenes.$thumb)){
						$thumb = $this->_limpiarAcentos($Nombre).$i.'_thumb'.$imagen['file_ext'];
						$i++;
					}
					copy($rutaImagenes.$nuevoNombre, $rutaImagenes.$thumb);
									
					$this->load->library('image_lib');
					$config2['image_library'] = 'gd2';
					$config2['source_image']= $rutaImagenes.$thumb;
					$config2['width'] = '216';
					$config2['height']= '116';
					$config2['maintain_ratio'] = TRUE;
					$config2['master_dim'] = 'width';
					$config2['create_thumb'] = FALSE;
					$this->image_lib->initialize($config2);
					if ( ! $this->image_lib->resize()){
						$msg = $this->image_lib->display_errors();
						$tipo = 'error';
						$messages[] = array('msg' => $msg, 'tipo' => $tipo);
						$img = $thumb ='';
					}
					
				}else{//file_name
					$img = $thumb ='';
				}//file_name
			}//upload
			/************************************************************************************/
			
			$this->mservicio->Imagen 	= $img;
			$this->mservicio->Thumb 	= $thumb;

			$q = $this->mservicio->agregar();
			if($q){
				$msg = 'Servicio agregado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/servicios/listar", 'refresh');
			}else{
				$msg = 'Ocurrió un error agregando el servicio';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
			
		}
		
		$this->load->helper('form');
		
		$cv['messages']	= $messages;
		
		$tv['title'] = 'Agregar servicio';
		
		$tv['content'] = $this->load->view('administracion/servicio/agregar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}//agregar
	
	//Editar
	function editar(){
				
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_servicio = ($this->input->post('ID_servicio'))?$this->input->post('ID_servicio'):$this->uri->segment('4');
		$this->mservicio->ID_servicio= $ID_servicio;
		$servicio = $this->mservicio->obtener_uno();
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Intro', 'Intro', 'required|xss_clean');
		$this->form_validation->set_rules('Descripcion', 'Descripción', 'required|xss_clean');

		if($this->form_validation->run()){
			$Nombre = $this->input->post('Nombre');
			$this->mservicio->Nombre = $Nombre;
			$this->mservicio->Intro = $this->input->post('Intro');	
			$this->mservicio->Descripcion = $this->input->post('Descripcion');
			$this->mservicio->Activo = $this->input->post('Activo');
			
			/**************FOTO****************/
			if($_FILES['Imagen']['name'] != ''){
				$rutaImagenes = 'fotos/servicios/';
				
				$this->load->library('upload');
				$config['upload_path'] = $rutaImagenes;
				$config['allowed_types'] = 'jpg|png';
				$config['max_size']	   = '5000';
				$this->upload->initialize($config);
	
				if(!$this->upload->do_upload('Imagen')){
					$img = $thumb ='';
					$msg = $this->upload->display_errors();
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					
				}else{//upload
					$imagen = $this->upload->data();
					if($imagen['file_name']){
						$nuevoNombre = $this->_limpiarAcentos($Nombre).$imagen['file_ext'];
						
						$img = $nuevoNombre;
						unlink($rutaImagenes.$servicio->Imagen);
						unlink($rutaImagenes.$servicio->Thumb);
						rename($rutaImagenes.$imagen['file_name'], $rutaImagenes.$nuevoNombre);
						$thumb = $this->_limpiarAcentos($Nombre).'_thumb'.$imagen['file_ext'];
						copy($rutaImagenes.$nuevoNombre, $rutaImagenes.$thumb);
										
						$this->load->library('image_lib');
						$config2['image_library'] = 'gd2';
						$config2['source_image']= $rutaImagenes.$thumb;
						
						$config2['width'] = '216';
						$config2['height']= '116';
						$config2['maintain_ratio'] = TRUE;
						$config2['master_dim'] = 'width';
						$config2['create_thumb'] = FALSE;
						$this->image_lib->initialize($config2);
						if ( ! $this->image_lib->resize()){
							$msg = $this->image_lib->display_errors();
							$tipo = 'error';
							$messages[] = array('msg' => $msg, 'tipo' => $tipo);
							$img = $thumb ='';
						}
						
					}else{//file_name
						$img = $thumb ='';
					}//file_name
				}//upload

			}//if($_FILES)
			/************************************************************************************/
			
			
			$q = $this->mservicio->editar();
			if($q){
				$msg = 'Servicio modificado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/servicios/listar", 'refresh');
			}else{
				$msg = 'Ocurrió un error modificando el servicio';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
		}
		
		$cv['s'] = $servicio;
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$tv['includes'][] = script_tag('js/editar.js');
		$tv['title'] = 'Editar servicio';
		
		$tv['content'] = $this->load->view('administracion/servicio/editar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function eliminar(){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$this->load->model('mservicio');

		$ID_servicio = ($this->input->post('ID_servicio'))?$this->input->post('ID_servicio'):$this->uri->segment('4');
		
	 	/*if(!$this->input->is_ajax_request()){
			//Si no viene de JS, confirmar la eliminación del elemento
			$msg = 'Seguro que realmente desea eliminar este servicio?';
			$tipo = 'exito';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/servicio/editar/".$ID_servicio, 'refresh');
		}*/
		
		if($ID_servicio){
			$rutaImagenes = 'fotos/servicios/';
			
			$this->mservicio->ID_servicio = $ID_servicio;
			$s = $this->mservicio->obtener_uno();
			
			unlink($rutaImagenes.$s->Imagen);
			unlink($rutaImagenes.$s->Thumb);
			
			$q = $this->mservicio->delete();
			if($q){
				$msg = 'Se elimino correctamente el servicio';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			}else{
				$msg = 'No se pudo eliminar el servicio';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);	
			}
		}else{
			$msg = 'No se indicó el servicio a eliminar';
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
		}
		
		$this->session->set_flashdata('messages', $messages);
		redirect("administracion/servicios/listar", 'refresh');
		
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

/* End of file servicios.php */
/* Location: ./application/controllers/administracion/servicios.php */