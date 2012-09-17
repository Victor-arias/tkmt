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

	public function listar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		if($this->uri->segment('4')){
			$cv['album'] = '/'.$this->mfoto->ID_foto_album = $this->uri->segment('4');
		}else{
			$cv['album'] = '';
		}

		$cv['fotos'] = $this->mfoto->obtener();

		$cv['messages']		= $messages;
		
		$tv['title'] = 'Fotografía';
		$tv['content'] = $this->load->view('administracion/fotografia/listar', $cv, true);
		$this->load->view('administracion/template', $tv);
	}

	public function agregar()
	{
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$this->load->model(array('mfoto_album', 'mfoto'));
			
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
				
		if ($this->form_validation->run() == true){
			$Nombre = $this->input->post('Nombre');
			$Foto = $this->input->post('Foto');
			
			
			
			$this->mfoto_album->ID_foto_album = $this->input->post('Foto_album');
			$album = $this->mfoto_album->obtener_uno();
			/**************FOTO****************/
			$rutaImagenes = 'fotos/galeria/';
			if(!is_dir($rutaImagenes.$album->Alias)){
				mkdir($rutaImagenes.$album->Alias);
			}
			$rutaImagenes = $rutaImagenes.$album->Alias."/";
			$this->load->library('upload');
			$config['upload_path'] = $rutaImagenes;
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	   = '6000';
			$this->upload->initialize($config);

			if(!$this->upload->do_upload('Foto')){
				$img = '';
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
					$thumb = $this->_limpiarAcentos($Nombre) .'_thumb'.$imagen['file_ext'];
					$i = 1;
					while(file_exists($rutaImagenes.$thumb)){
						$thumb = $this->_limpiarAcentos($Nombre) . $i .'_thumb'.$imagen['file_ext'];
						$i++;
					}
					copy($rutaImagenes.$nuevoNombre, $rutaImagenes.$thumb);
								
					$this->load->library('image_lib');
					$config2['image_library'] = 'gd2';
					$config2['source_image']= $rutaImagenes.$thumb;
					$config2['width'] = '100';
					$config2['height']= '100';
					$config2['maintain_ratio'] = TRUE;
					$config2['master_dim'] = 'auto';
					$config2['create_thumb'] = FALSE;
					$this->image_lib->initialize($config2);
					if ( ! $this->image_lib->resize()){
						$img = '';
						$msg = $this->image_lib->display_errors();
						$tipo = 'error';
						$messages[] = array('msg' => $msg, 'tipo' => $tipo);
					}else{
						$this->mfoto->Foto 			= $rutaImagenes.$img;
						$this->mfoto->Thumb			= $rutaImagenes.$thumb;
					}
					
				}//file_name
			}//upload
			
			/************************************************************************************/
			$this->mfoto->Nombre = $Nombre;
			$this->mfoto->ID_foto_album  = $this->input->post('Foto_album');
			$this->mfoto->Fecha_publicacion = date('Y-m-d H:i:s'); 
			$this->mfoto->Activo = 1;
			if($img){	
				$q = $this->mfoto->agregar();
			}else{
				$q = false;
			}
			if($q){
				//redirect them back to the admin page
				$msg = 'Fotografía agregada con éxito';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/fotografia/listar/".$album->ID_foto_album, 'refresh');
			}else{
				$msg = 'Ocurrió un error agregando la fotografía';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);	
			}
		}
		
		foreach($this->mfoto_album->obtener() as $album)
			$cv['Foto_album'][$album->ID_foto_album] = $album->Nombre;
		
		$this->load->helper('form');
		
		$cv['messages']		= $messages;
		
		$cv['ID_foto_album'] = ($this->uri->segment('4'))?$this->uri->segment('4'):0;
		
		$tv['title'] = 'Agregar Fotografía';
		$tv['content'] = $this->load->view('administracion/fotografia/agregar', $cv, true);
		$tv['includes'][] = script_tag('js/fotografia.js');
		$this->load->view('administracion/template', $tv);
	}//agregar

	public function eliminar($id, $album = false){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_foto = ($id)?$id:$this->uri->segment('4');
		
		if($ID_foto){
			$this->mfoto->ID_foto = $ID_foto;
			$foto = $this->mfoto->obtener_uno();
			if(unlink($foto->Thumb) && unlink($foto->Foto)){
				$q = $this->mfoto->delete();
				if($q){
					$msg = 'Se elimino correctamente la fotografía';
					$tipo = 'exito';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);

				}else{
					$msg = 'No se pudo eliminar la fotografía';
					$tipo = 'error';
					$messages[] = array('msg' => $msg, 'tipo' => $tipo);	
				}
			}
		}else{
			$msg = 'No se indicó la fotografía a eliminar';
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
		}
		$this->session->set_flashdata('messages', $messages);
		if(!$album)
			redirect("administracion/fotografia/listar", 'refresh');
		
	}
	
	public function listar_album()
	{
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$cv['messages']		= $messages;
		$cv['albumes'] 	= $this->mfoto_album->obtener();
		
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
	
	public function eliminar_album(){
		$messages = array();
 		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$ID_foto_album = ($this->input->post('ID_foto_album'))?$this->input->post('ID_foto_album'):$this->uri->segment('4');
		
		if($ID_foto_album){
			$this->mfoto_album->ID_foto_album = $ID_foto_album;
			$foto_album = $this->mfoto_album->obtener_uno();

			$this->mfoto->ID_foto_album = $ID_foto_album;
			$fotos = $this->mfoto->obtener();
			if($fotos)
				foreach($fotos as $foto){
					$this->eliminar($foto->ID_foto, true);
				}
			$q = $this->mfoto_album->delete();
			if($q){
				$msg = 'Se elimino correctamente eñ album';
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);

			}else{
				$msg = 'No se pudo eliminar el album';
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);	
			}

		}else{
			$msg = 'No se indicó el album a eliminar';
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
		}
		
		$this->session->set_flashdata('messages', $messages);
		redirect("administracion/fotografia/listar_album", 'refresh');
		
	}

	public function _reordenar($orden, $ID_foto_album = 0){
		if($ID_foto_album != 0) $this->mfoto_album->ID_foto_album;
		$this->mfoto_album->reordenar($orden);
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
		$s = ereg_replace("\"","",$s);
		return $s;
	} 

}

/* End of file tekemate.php */
/* Location: ./application/controllers/administracion/fotografia/tekemate.php */