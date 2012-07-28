<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model('mvideo');
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
		
		if($this->uri->segment('4')) $this->mvideo->ID_categoria_video = $this->uri->segment('4');
				
		$cv['videos'] = $this->mvideo->obtener();
			
		$cv['messages']		= $messages;
		
		$tv['title'] = 'Vídeo';
		$tv['content'] = $this->load->view('administracion/video/listar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function agregar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$this->load->model(array('mproveedor_video', 'mcategoria_video', 'mmedia'));
			
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Descripcion', 'Descripción', 'xss_clean');
		$this->form_validation->set_rules('Video_ID', 'Video_ID', 'required');
				
		if ($this->form_validation->run() == true){
			$Video_ID = $this->input->post('Video_ID');
			$Nombre = $this->input->post('Nombre');
			$Alias = url_title($Nombre, 'dash', TRUE);
			
			$this->mvideo->Video_ID = $Video_ID;
			if(!$vi = $this->mvideo->obtener_uno()){
				$this->mvideo->Video_ID = NULL;
				$this->mvideo->Alias = $Alias;
				if($va = $this->mvideo->obtener_uno()){
					$Alias = url_title($Nombre.rand(rand(0,20), rand(20, 100)), 'dash', TRUE);
				}
				$this->mvideo->Nombre = $Nombre;
				$this->mvideo->Alias = $Alias;
				$this->mvideo->ID_categoria_video = $this->input->post('Categoria');
				$this->mvideo->Descripcion = $this->input->post('Descripcion');
				$this->mvideo->ID_proveedor_video = $this->input->post('Proveedor');
				$this->mvideo->Video_ID = $Video_ID;
				$this->mvideo->Fecha_publicacion = date('Y-m-d H:i:s'); 
				$this->mvideo->Activo = 1;
				
				/**************FOTO****************/
				$rutaImagenes = 'fotos/videos/';
			
				$this->load->library('upload');
				$config['upload_path'] = $rutaImagenes;
				$config['allowed_types'] = 'jpg|png';
				$config['max_size']	   = '5000';
				$this->upload->initialize($config);

				if(!$this->upload->do_upload('Thumb')){
					$img = '';
					$msg = $this->upload->display_errors();
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$imgid = 43;
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
															
						$this->load->library('image_lib');
						$config2['image_library'] = 'gd2';
						$config2['source_image']= $rutaImagenes.$img;
						$config2['width'] = '200';
						$config2['height']= '150';
						$config2['maintain_ratio'] = TRUE;
						$config2['master_dim'] = 'width';
						$config2['create_thumb'] = FALSE;
						$this->image_lib->initialize($config2);
						if ( ! $this->image_lib->resize()){
							$msg = $this->image_lib->display_errors();
							$tipo = 'error';
							$messages[] = array('msg' => $msg, 'tipo' => $tipo);
							$imgid = 43;
						}else{
							$this->mmedia->Tipo			= $imagen['image_type'];
							$this->mmedia->Url 			= $rutaImagenes.$img;
							$this->mmedia->Texto_alternativo = $Nombre;
							$this->mmedia->Ancho		= $config2['width'];
							$this->mmedia->Alto			= $config2['height'];
							$this->mmedia->Subido		= date('Y-m-d H:i:s');
							$this->mmedia->Activo		= 1;
							$imgid = $this->mmedia->agregar();
						}
						
					}else{//file_name
						$imgid = 43;
					}//file_name
				}//upload
				
				/************************************************************************************/
				$this->mvideo->ID_media = $imgid;
				
				$q = $this->mvideo->agregar();
				if($q){
					//redirect them back to the admin page
					$msg = 'Vídeo agregado con éxito';
					$tipo = 'exito';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);
					redirect("administracion/video/listar", 'refresh');
				}else{
					$msg = 'Ocurrió un error agregando el vídeo';
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);	
				}
			}else{
				$msg = 'El video ya se encuentra en la base de datos';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);		
			}
		}
		
		foreach($this->mproveedor_video->obtener() as $proveedor)
			$cv['Proveedor'][$proveedor->ID_proveedor_video] = $proveedor->Nombre;
		
		foreach($this->mcategoria_video->obtener() as $categoria)
			$cv['Categoria'][$categoria->ID_categoria_video] = $categoria->Nombre;
		
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$cv['ID_categoria_video'] = ($this->uri->segment('4'))?$this->uri->segment('4'):0;
		
		$tv['title'] = 'Agregar Vídeo';
		$tv['content'] = $this->load->view('administracion/video/agregar', $cv, true);
		$tv['includes'][] = script_tag('js/video.js');
		$this->load->view('administracion/template', $tv);
	}//agregar
	
	public function editar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$this->load->model(array('mproveedor_video', 'mvideo', 'mcategoria_video', 'mmedia'));

		$ID_video = ($this->input->post('ID_video'))?$this->input->post('ID_video'):$this->uri->segment('4');
		
		$this->mvideo->ID_video = $ID_video;
		$video = $this->mvideo->obtener_uno();
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Alias', 'Alias', 'url_title|is_unique[Categoria_video.Alias]|xss_clean');
		$this->form_validation->set_rules('Descripcion', 'Descripción', 'xss_clean');
		$this->form_validation->set_rules('Video_ID', 'Video_ID', 'required');
		
		if ($this->form_validation->run() == true){
			$Video_ID = $this->input->post('Video_ID');
			$Nombre = $this->input->post('Nombre');
			
			$this->mvideo->Video_ID = $Video_ID;
			if($vi = $this->mvideo->obtener_uno()){
				
				$this->mvideo->ID_video = $this->input->post('ID_video');
				$this->mvideo->ID_categoria_video = $this->input->post('Categoria');
				$this->mvideo->Nombre = $Nombre;
				$this->mvideo->Alias = ($this->input->post('Alias'))?$this->input->post('Alias'):url_title($Nombre, 'dash', TRUE);
				$this->mvideo->Descripcion = $this->input->post('Descripcion');
				$this->mvideo->Video_ID = $Video_ID;
				$this->mvideo->ID_proveedor_video = $this->input->post('Proveedor');
				$this->mvideo->Activo = ($this->input->post('Activo'))?1:0;
				
				/**************FOTO****************/
				if($_FILES['Thumb']['name'] != ''){
					$rutaImagenes = 'fotos/videos/';
				
					$this->load->library('upload');
					$config['upload_path'] = $rutaImagenes;
					$config['allowed_types'] = 'jpg|png';
					$config['max_size']	   = '5000';
					$this->upload->initialize($config);
	
					if(!$this->upload->do_upload('Thumb')){
						$img = '';
						$msg = $this->upload->display_errors();
						$tipo = 'error';
						$messages[] = array('msg' => $msg, 'tipo' => $tipo);
						$imgid = 43;
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
							
							if($vi->ID_media != 43){
								if(unlink($vi->Url)){
									$this->mmedia->ID_media = $vi->ID_media;
									$this->mmedia->delete();
									$this->mmedia->clear();	
								}
							}
							
							rename($rutaImagenes.$imagen['file_name'], $rutaImagenes.$nuevoNombre);
																
							$this->load->library('image_lib');
							$config2['image_library'] = 'gd2';
							$config2['source_image']= $rutaImagenes.$img;
							$config2['width'] = '200';
							$config2['height']= '150';
							$config2['maintain_ratio'] = TRUE;
							$config2['master_dim'] = 'width';
							$config2['create_thumb'] = FALSE;
							$this->image_lib->initialize($config2);
							if ( ! $this->image_lib->resize()){
								$msg = $this->image_lib->display_errors();
								$tipo = 'error';
								$messages[] = array('msg' => $msg, 'tipo' => $tipo);
								$imgid = 43;
							}else{
								$this->mmedia->Tipo			= $imagen['image_type'];
								$this->mmedia->Url 			= $rutaImagenes.$img;
								$this->mmedia->Texto_alternativo = $Nombre;
								$this->mmedia->Ancho		= $config2['height'];
								$this->mmedia->Alto			= $config2['height'];
								$this->mmedia->Subido		= date('Y-m-d H:i:s');
								$this->mmedia->Activo		= 1;
								$imgid = $this->mmedia->agregar();
								$this->mvideo->ID_media = $imgid;
							}
							
						}else{//file_name
							$imgid = 43;
						}//file_name
					}//upload
				}
				/************************************************************************************/
				
				
				$q = $this->mvideo->editar();
				if($q){
					//redirect them back to the admin page
					$msg = 'Vídeo modificado con éxito';
					$tipo = 'exito';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);
					redirect("administracion/video/listar", 'refresh');
				}else{
					$msg = 'Ocurrió un error modificando el video';
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					$this->session->set_flashdata('messages', $messages);	
				}
			}else{
				$msg = 'El video no se encuentra en la base de datos';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);		
			}
			
		}
				
		foreach($this->mproveedor_video->obtener() as $proveedor)
			$cv['Proveedor'][$proveedor->ID_proveedor_video] = $proveedor->Nombre;
		
		foreach($this->mcategoria_video->obtener() as $categoria)
			$cv['Categoria'][$categoria->ID_categoria_video] = $categoria->Nombre;
		
		$cv['v'] = $video;
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$tv['includes'][] = script_tag('js/video.js');
		$tv['includes'][] = script_tag('js/editar.js');
		$tv['title'] = 'Editar Vídeo ' . $video->Nombre;
		
		$tv['content'] = $this->load->view('administracion/video/editar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function eliminar(){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_video = ($this->input->post('ID_video'))?$this->input->post('ID_video'):$this->uri->segment('4');
		
	 	/*if(!$this->input->is_ajax_request()){
			//Si no viene de JS, confirmar la eliminación del elemento
			$msg = 'Seguro que realmente desea eliminar este video?';
			$tipo = 'exito';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/video/editar/".$ID_video, 'refresh');
		}*/
		
		if($ID_video){
			$this->mvideo->ID_video = $ID_video;
			$q = $this->mvideo->delete();
			if($q){
				$msg = 'Se elimino correctamente el video';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			}else{
				$msg = 'No se pudo eliminar el video';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);	
			}
		}else{
			$msg = 'No se indicó el video a eliminar';
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
		}
		
		$this->session->set_flashdata('messages', $messages);
		redirect("administracion/video/listar", 'refresh');
		
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
		$s = ereg_replace("\"","",$s);
		return $s;
	} 
		
}

/* End of file video.php */
/* Location: ./application/controllers/administracion/video.php */