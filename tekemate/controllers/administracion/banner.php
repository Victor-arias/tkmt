<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');
		$this->load->model(array('mbanner', 'mmedia'));
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
		$cv['banners'] = $this->mbanner->obtener();
		
		$tv['title'] = 'Banner';
		//$tv['sidebar'] = $this->load->view('sidebar/inicio', false, true);
		$tv['includes'][] = link_tag('styles/jquery.fancybox-1.3.4.css');
		$tv['includes'][] = script_tag('js/libs/jquery.fancybox-1.3.4.pack.js');
		$tv['includes'][] = script_tag('js/admon_banner.js');
		$tv['content'] = $this->load->view('administracion/banner/listar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function agregar_imagen()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Url', 'Url', 'required|prep_url|xss_clean');
		
		if ($this->form_validation->run() == true){
			$Nombre = $this->input->post('Nombre');
			$this->mbanner->Nombre = $Nombre;
			$this->mbanner->Url = $this->input->post('Url');
			$this->mbanner->Orden = 1;
			$this->mbanner->Agregado = date('Y-m-d H:i:s');
			$this->mbanner->Publicado = ($this->input->post('Publicar'))?1:0;
			$this->mbanner->Activo = ($this->input->post('Activo'))?1:0;
			
			/**************FOTO****************/
			$rutaImagenes = 'fotos/banners/';
			
			$this->load->library('upload');
			$config['upload_path'] = $rutaImagenes;
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	   = '500';
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
					$config2['width'] = '92';
					$config2['height']= '32';
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
					$this->mmedia->Tipo			= $imagen['image_type'];
					$this->mmedia->Url 			= $rutaImagenes.$img;
					$this->mmedia->Texto_alternativo = $Nombre;
					$this->mmedia->Ancho		= $imagen['image_width'];
					$this->mmedia->Alto			= $imagen['image_height'];
					$this->mmedia->Subido		= date('Y-m-d H:i:s');
					$this->mmedia->Activo		= 1;
					$imgid = $this->mmedia->agregar();
					
					$this->mmedia->clear();
					
					$this->mmedia->Tipo			= $imagen['image_type'];
					$this->mmedia->Url 			= $rutaImagenes.$thumb;
					$this->mmedia->Texto_alternativo = $Nombre;
					$this->mmedia->Ancho		= $config2['width'];
					$this->mmedia->Alto			= $config2['height'];
					$this->mmedia->Subido		= date('Y-m-d H:i:s');
					$this->mmedia->Activo		= 1;
					$thumbid = $this->mmedia->agregar();
				}else{//file_name
					$img = $thumb ='';
					$imgid = $thumbid = 0;
				}//file_name
			}//upload
			/************************************************************************************/
			
			$this->mbanner->ID_media = $imgid;
			$this->mbanner->ID_media_thumb = $thumbid;

			$q = $this->mbanner->agregar();
			if($q){
				$msg = 'Banner agregado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/banner/listar", 'refresh');
			}else{
				$msg = 'Ocurrió un error agregando el banner';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
			
		}
		
		$this->load->helper('form');
		
		$cv['messages']	= $messages;
		
		$tv['title'] = 'Agregar banner';
		
		$tv['content'] = $this->load->view('administracion/banner/agregar_imagen', $cv, true);
		$this->load->view('administracion/template', $tv);
	}//agregar
	
	//Editar
	function editar(){
				
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_banner = ($this->input->post('ID_banner'))?$this->input->post('ID_banner'):$this->uri->segment('4');
		$this->mbanner->ID_banner= $ID_banner;
		$banner = $this->mbanner->obtener_uno();
		
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Url', 'Url', 'required|prep_url|xss_clean');
		
		if($this->form_validation->run()){
			$Nombre = $this->input->post('Nombre');
			$this->mbanner->Nombre = $Nombre;
			$this->mbanner->Url = $this->input->post('Url');
			$this->mbanner->Orden = 1;
			$this->mbanner->Publicado = ($this->input->post('Publicar'))?1:0;
			$this->mbanner->Activo = ($this->input->post('Activo'))?1:0;
			/**************FOTO****************/

			if($_FILES['Imagen']['name'] != ''){
				$rutaImagenes = 'fotos/banners/';
				
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
						$i = 1; 
						while(file_exists($rutaImagenes.$nuevoNombre)){
							$nuevoNombre = $this->_limpiarAcentos($Nombre).$i.$imagen['file_ext'];
							$i++;
						}
						
						if(unlink($banner->mUrl)){
							$this->mmedia->ID_media = $banner->mUrl;
							$this->mmedia->delete();
							$this->mmedia->clear();	
						}
						if(unlink($banner->tUrl)){
							$this->mmedia->ID_media = $banner->tUrl;
							$this->mmedia->delete();	
							$this->mmedia->clear();
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
						$config2['width'] = '92';
						$config2['height']= '32';
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
						$this->mmedia->Tipo			= $imagen['image_type'];
						$this->mmedia->Url 			= $rutaImagenes.$img;
						$this->mmedia->Texto_alternativo = $Nombre;
						$this->mmedia->Ancho		= $imagen['image_width'];
						$this->mmedia->Alto			= $imagen['image_height'];
						$this->mmedia->Subido		= date('Y-m-d H:i:s');
						$this->mmedia->Activo		= 1;
						$imgid = $this->mmedia->agregar();
						
						$this->mmedia->clear();
						
						$this->mmedia->Tipo			= $imagen['image_type'];
						$this->mmedia->Url 			= $rutaImagenes.$thumb;
						$this->mmedia->Texto_alternativo = $Nombre;
						$this->mmedia->Ancho		= $config2['width'];
						$this->mmedia->Alto			= $config2['height'];
						$this->mmedia->Subido		= date('Y-m-d H:i:s');
						$this->mmedia->Activo		= 1;
						$thumbid = $this->mmedia->agregar();
						$this->mbanner->ID_media = $imgid;
						$this->mbanner->ID_media_thumb = $thumbid;
					}else{//file_name
						$img = $thumb ='';
					}//file_name
				}//upload

			}//if($_FILES)
			/************************************************************************************/
			
			
			$q = $this->mbanner->editar();
			if($q){
				$msg = 'Banner modificado con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/banner/listar", 'refresh');
			}else{
				$msg = 'Ocurrió un error modificando el banner';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
		}
		
		$cv['b'] = $banner;
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$tv['includes'][] = script_tag('js/editar.js');
		$tv['title'] = 'Editar banner';
		
		$tv['content'] = $this->load->view('administracion/banner/editar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}
	
	public function eliminar_imagen(){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');

		$ID_banner = ($this->input->post('ID_banner'))?$this->input->post('ID_banner'):$this->uri->segment('4');
		
	 	/*if(!$this->input->is_ajax_request()){
			//Si no viene de JS, confirmar la eliminación del elemento
			$msg = 'Seguro que realmente desea eliminar este servicio?';
			$tipo = 'exito';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/servicio/editar/".$ID_servicio, 'refresh');
		}*/
		
		if($ID_banner){
			$rutaImagenes = 'fotos/banners/';
			
			$this->mbanner->ID_banner = $ID_banner;
			$b = $this->mbanner->obtener_uno();
			
			unlink($b->mUrl);
			unlink($b->tUrl);
			
			$q = $this->mbanner->delete();
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
		redirect("administracion/banner/listar", 'refresh');
		
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

/* End of file banner.php */
/* Location: ./application/controllers/administracion/banner.php */