<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tekemate extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$this->output->enable_profiler(true);
		/*$this->load->library(array('ion_auth', 'form_validation'));
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin()) redirect(base_url(), 'refresh');*/
		$this->load->model('mbanner');
	}
	
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->load->model(array('mrecomendado', 'mproveedor_video'));
		$r = $this->mrecomendado->obtener_uno(true);
		$this->mproveedor_video->ID_proveedor_video = $r->ID_proveedor_video;
		$sv['proveedor'] = $this->mproveedor_video->obtener_uno();
		$sv['recomendado'] = $r;
		
		$tv['title'] = 'Inicio';
		$tv['keywords'] = 'Producción, realización, contenidos, audiovisual, video, fotografía, medellín, imagen digital';
		$tv['description'] = 'Somos un grupo de profesiones de la producción audiovisual, dispuestos a diseñar y elaborar ideas creativas y eficaces para todo tipo de productos.';
		$tv['content'][] = $this->load->view('tekemate/inicio', false, true);
		$tv['content'][] = $this->load->view('sidebar/inicio', $sv, true);
		$this->load->view('template', $tv);
	}//index
	
	public function servicios()
	{
		$tv['title'] = 'Servicios';
		$tv['keywords'] = 'Producción, realización, contenidos, diusión, audiovisual, video, fotografía, imágenes, herramientas de comunicación, locución, cubrimiento de eventos, medellín, imagen digital';
		$tv['description'] = 'Creamos contenidos audiovisuales e informativos efectivos, llamativos, innovadores y eficaces, satisfaciendo la necesidad de difusión de todos nuestros clientes.';
		$tv['content'] = $this->load->view('tekemate/servicios', false, true);
		$tv['includes'][] = script_tag('js/servicios.js');
		$this->load->view('template', $tv);
	}//servicios
	
	public function galeria()
	{
		$tv['title'] = 'Galería';
		$tv['keywords'] = 'Producción, realización, contenidos, diusión, audiovisual, video, fotografía, imágenes, herramientas de comunicación, locución, cubrimiento de eventos, medellín, imagen digital';
		$tv['description'] = 'Creamos contenidos audiovisuales e informativos efectivos, llamativos, innovadores y eficaces, satisfaciendo la necesidad de difusión de todos nuestros clientes.';
		$tv['content'] = $this->load->view('tekemate/galeria', false, true);
		$tv['includes'][] = script_tag('js/servicios.js');
		$this->load->view('template', $tv);
	}//galeria

	public function servicio()
	{
		
		$s['servicio'] = $this->uri->segment(2);
		$tv['title'] = 'Servicio ';
		$tv['keywords'] = '';
		$tv['description'] = '';
		//$tv['includes'][] = script_tag('js/servicio.js');
		if($this->input->is_ajax_request()){
			$tv['content'] = $this->load->view('tekemate/servicio', $s, true);
			$this->load->view('template', $tv);
		}else{
			$this->load->view('tekemate/servicio', $s);
		}
	}//lo_que_hacemos
	
	public function lo_que_hacemos()
	{
		$tv['title'] = 'Lo que hacemos';
		$tv['keywords'] = 'Producción, realización, contenidos, diusión, audiovisual, video, fotografía, imágenes, herramientas de comunicación, locución, cubrimiento de eventos, medellín, imagen digital';
		$tv['description'] = 'Creamos contenidos audiovisuales e informativos efectivos, llamativos, innovadores y eficaces, satisfaciendo la necesidad de difusión de todos nuestros clientes.';
		$tv['content'] = $this->load->view('tekemate/lo_que_hacemos', false, true);
		$this->load->view('template', $tv);
	}//lo_que_hacemos
	
	public function fotografia()
	{
		$tv['title'] = 'Fotografía';
		$tv['keywords'] = 'fotografía,calidad, moda, retrato, books, catálogos, modelos, actores, deportistas, artistas musicales, producto, alta resolución, digital, publicitaria, arquitectónica, espacios, industrial, comidas, alimentos, bebidas, eventos, medellín';
		$tv['description'] = 'Ofrecemos una amplia gama de servicios fotográficos con la mejor calidad y diseño en Moda, Retratos, Books, Fotografía Publicitaria, entre otros.';
		$tv['content'] = $this->load->view('tekemate/fotografia', false, true);
		$tv['includes'][] = script_tag('js/libs/jquery.jcarousel.min.js');
		$tv['includes'][] = script_tag('js/fotografia.js');
		$this->load->view('template', $tv);
	}//fotografía

/*	public function video()
	{
		$tv['title'] = 'Vídeo';
		$tv['keywords'] = 'vídeos, musicales, institucionales, corporativos, argumentales, documentales, comerciales, promos, dirección, realización, producción, eventos, medellín';
		$tv['description'] = ' Te brindamos la oportunidad de trasmitir por medio de imágenes y audio el sentir de tu compañía con la capacidad de promocionarse por si mismo, con los más altos estándares de calidad y en diferentes formatos.';
		$tv['content'] = $this->load->view('tekemate/video', false, true);
		$tv['includes'][] = script_tag('js/video.js');
		$this->load->view('template', $tv);
	}//galeria
	*/
	public function videoxx()
	{
		//Inicializao la petición cURL
		$c = curl_init('http://vimeo.com/api/v2/tekemate/videos.json'/*'http://gdata.youtube.com/feeds/api/users/tekemateid/uploads?v=2&alt=json'*/);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$datos = curl_exec($c); //Ejecuto la petición
		curl_close($c);
		$datos = json_decode($datos);
		$cv['videos'] = $datos;
		
		$tv['title'] = 'Vídeo';
		$tv['keywords'] = 'vídeos, musicales, institucionales, corporativos, argumentales, documentales, comerciales, promos, dirección, realización, producción, eventos, medellín';
		$tv['description'] = ' Te brindamos la oportunidad de trasmitir por medio de imágenes y audio el sentir de tu compañía con la capacidad de promocionarse por si mismo, con los más altos estándares de calidad y en diferentes formatos.';
		$tv['content'] = $this->load->view('tekemate/video', $cv, true);
		$tv['includes'][] = script_tag('js/video.js');
		$this->load->view('template', $tv);
	}//galeria
	
	public function video3()
	{
		$this->load->model(array('mcategoria_video', 'mvideo'));
		
		$categorias = $this->mcategoria_video->obtener();
		foreach($categorias as $categoria){
			$this->mvideo->ID_categoria_video = $categoria->ID_categoria_video;
			$videos[$categoria->Nombre] = $this->mvideo->obtener();	
		}
		
		$cv['categorias'] = $videos;
		
		$tv['title'] = 'Vídeo';
		$tv['keywords'] = 'vídeos, musicales, institucionales, corporativos, argumentales, documentales, comerciales, promos, dirección, realización, producción, eventos, medellín';
		$tv['description'] = ' ¡Sé parte de nuestro equipo! y disfruta de las ventajas que ofrece la producción audiovisual para ti y tu negocio.';
		$tv['content'] = $this->load->view('tekemate/video3', $cv, true);
		$tv['includes'][] = script_tag('js/video.js');
		$this->load->view('template', $tv);
	}//galeria
	
	public function video()
	{
		//$this->load->driver('cache');
		
		//if (!$final = $this->cache->get('final')){
		
			$url_listas = '';
			$c = curl_init('http://gdata.youtube.com/feeds/api/users/tekemateid/playlists?v=2&alt=json');
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			$datos = curl_exec($c); //Ejecuto la petición
			curl_close($c);
			$listas = json_decode($datos);
			//$listas = _cargar_json($url_listas);
					
			$videos = $final = array();

			if($listas != ''){
				foreach($listas->feed->entry as $l){
//					print_r($l->{'yt$playlistId'}).'<br />';
					if($l->{'yt$playlistId'}->{'$t'} != '8A4753C31002A835' || $l->{'yt$playlistId'}->{'$t'} != '280EA9A419A02994'){
						$c = curl_init($l->content->src.'&alt=json');
						curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
						$datos = curl_exec($c); //Ejecuto la petición
						curl_close($c);
						$videos[] = json_decode($datos);
						//
						foreach($videos as $v):
							 foreach($v->feed->entry as $vi):
								 $videitos[] = array('title' => $vi->title,
													 'url' => 'http://www.youtube.com/embed/'.$vi->{'media$group'}->{'yt$videoid'}->{'$t'},
													 'thumbnail'=>$vi->{'media$group'}->{'media$thumbnail'}[0]);
							 endforeach;
						endforeach;
						$final[] = array('list' => $l->title, 'summary' => $l->summary, 'content' => $videitos);
					}
				}
			}else{
				$final = array();
			}
		
		
			 // Save into the cache for 10 minutes
			// $this->cache->save('final', $final, 600);
		//}
		
		$cv['videos'] = $final;
		
		$tv['title'] = 'Vídeo';
		$tv['keywords'] = 'vídeos, musicales, institucionales, corporativos, argumentales, documentales, comerciales, promos, dirección, realización, producción, eventos, medellín';
		$tv['description'] = ' Te brindamos la oportunidad de trasmitir por medio de imágenes y audio el sentir de tu compañía con la capacidad de promocionarse por si mismo, con los más altos estándares de calidad y en diferentes formatos.';
		$tv['content'] = $this->load->view('tekemate/video', $cv, true);
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
		
		$this->load->model('mcontacto');
		$sv['contacto'] = $this->mcontacto->obtener_uno();
		//$sv['cols'] = 'rightmenu';
		$this->load->helper('form');
		
		$tv['messages']	= $messages;		
		$tv['title'] 	= 'Contáctenos';
		$tv['keywords'] = 'contáctenos, servicios, cotización, medellín';
		$tv['description'] = 'Por favor escríbanos para asesorarlo con sus productos audiovisuales.';
		$tv['includes'][] = link_tag('styles/formalize.css');
		$tv['includes'][] = script_tag('js/libs/jquery.formalize.min.js');
		//$tv['sidebar'] 	= $this->load->view('sidebar/contacto', $sv, true);
		$tv['content'] 	= $this->load->view('tekemate/contacto', $sv, true);
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
	}
	
	public function _cargar_json($url){
		//Inicializao la petición cURL
		$c = curl_init($url.'&alt=json');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$datos = curl_exec($c); //Ejecuto la petición
		curl_close($c);
		return json_decode($datos);
	}
	
}

/* End of file tekemate.php */
/* Location: ./application/controllers/tekemate.php */