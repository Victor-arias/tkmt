<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('ion_auth', 'form_validation'));
	}
	function index(){
		if (!$this->ion_auth->logged_in()) 
			redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin())
			redirect($this->config->item('base_url'), 'refresh');
		else $this->listar();
	}
	
	function listar(){
		if (!$this->ion_auth->logged_in()) 
			redirect('administracion/usuario/iniciar_sesion', 'refresh');
		elseif (!$this->ion_auth->is_admin())
			redirect($this->config->item('base_url'), 'refresh');
		
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$cv['messages']		= $messages;
		$cv['usuarios'] 	= $this->ion_auth->get_users_array();
		
		$tv['title'] 			= 'Administración de Usuarios';
		$tv['content'][] 		= $this->load->view('administracion/usuario/listar', $cv, true); 
		$this->load->view('administracion/template', $tv);	
	}
	
	function iniciar_sesion()
	{
		if ($this->ion_auth->logged_in()) redirect('administracion/usuario', 'refresh');
		
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		if(validation_errors()) $messages[] = validation_errors();
		
		//validate form input
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Clave', 'required');

		if ($this->form_validation->run() == true)
		{ //check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
			{ //if the login is successful
				//redirect them back to the home page
				$msg = $this->ion_auth->messages();
				$tipo = 'exito';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect('administracion/usuario', 'refresh');
			}
			else
			{ //if the login was un-successful
				//redirect them back to the login page
				$msg = $this->ion_auth->errors();
				$tipo = 'info';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect('administracion/usuario/iniciar_sesion', 'refresh'); 
			}
		}
		else
		{  //the user is not logging in so display the login page
			//set the flash data error messages if there is one
			

			$cv['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$cv['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$cv['messages']		= $messages;			
			$tv['title'] 			= 'Administración - Iniciar sesión';
			$tv['content'][] 		= $this->load->view('administracion/usuario/iniciar_sesion', $cv, true); 
			$this->load->view('administracion/template', $tv);
		}
	}//iniciar_sesion
	
	function cerrar_sesion()
	{
		//log the user out
		$logout = $this->ion_auth->logout();
		//redirect them back to the page they came from
		redirect('administracion/usuario', 'refresh');
	}//cerrar_sesion
	
	function cambiar_clave()
	{
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		if(validation_errors()) $messages[] = validation_errors();
		
		$this->form_validation->set_rules('old', 'Clave anterior', 'required');
		$this->form_validation->set_rules('new', 'Clave nueva', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirmar clave nueva', 'required');
		if (!$this->ion_auth->logged_in()) redirect('administracion/usuario/iniciar_sesion', 'refresh');
		$user = $this->ion_auth->get_user($this->session->userdata('Id_usuario'));

		if ($this->form_validation->run() == false)
		{ //display the form
			//set the flash data error messages if there is one
			
			$cv['old_password'] = array('name' => 'old',
				'id' => 'old',
				'type' => 'password',
			);
			$cv['new_password'] = array('name' => 'new',
				'id' => 'new',
				'type' => 'password',
			);
			$cv['new_password_confirm'] = array('name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
			);
			$cv['Id_usuario'] = array('name' => 'Id_usuario',
				'id' => 'Id_usuario',
				'type' => 'hidden',
				'value' => $user->Id_usuario,
			);
			$cv['messages']		= $messages;
			//render
			$tv['title'] 			= 'Cambiar Clave';
			$tv['content'][] 		= $this->load->view('administracion/usuario/cambiar_clave', $cv, true); 
			$this->load->view('administracion/template', $tv);
		}
		else
		{
			$Id_usuarioentity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($Id_usuarioentity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{ //if the password was successfully changed
				$msg = $this->ion_auth->messages();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				$this->cerrar_sesion();
			}
			else
			{
				$msg = $this->ion_auth->errors();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect('administracion/usuario/cambiar_clave', 'refresh');
			}
		}
	}//cambiar_clave
	
	//recuperar_clave
	function recuperar_clave()
	{
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		if(validation_errors()) $messages[] = validation_errors();
		
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$cv['email'] = array('name' => 'email','id' => 'email',);
			log_message('error', 'validation');
			//set any errors and display the form
			$cv['messages']		= $messages;
			$tv['title'] 			= 'Recuperar clave';
			$tv['content'][] 		= $this->load->view('administracion/usuario/recuperar_clave', $cv, true); 
			$this->load->view('administracion/template', $tv);

		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ //if there were no errors
				$msg = $this->ion_auth->messages();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/usuario/iniciar_sesion", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$msg = $this->ion_auth->errors();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				log_message('error', 'forgotten -> ' . $msg);
				$this->session->set_flashdata('messages', $messages);
				redirect("administracion/usuario/recuperar_clave", 'refresh');
			}
		}
	}//recuperar_clave
	
	//reset password - final step for forgotten password
	public function reset_password($code)
	{
		$reset = $this->ion_auth->forgotten_password_complete($code);

		if ($reset)
		{  //if the reset worked then send them to the login page
			$msg = $this->ion_auth->messages();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
			redirect("administracion/usuario/iniciar_sesion", 'refresh');
		}
		else
		{ //if the reset didnt work then send them back to the forgot password page
			$msg = $this->ion_auth->errors();
				$tipo = 'error';
				$messages[] = array('msg' => $msg, 'tipo' => $tipo);
				$this->session->set_flashdata('messages', $messages);
			redirect("administracion/usuario/recuperar_clave", 'refresh');
		}
	}//reset password
	
	//activar
	function activar($Id_usuario, $code=false)
	{
		if ($code !== false)
			$activation = $this->ion_auth->activate($Id_usuario, $code);
		else if ($this->ion_auth->is_admin())
			$activation = $this->ion_auth->activate($Id_usuario);


		if ($activation)
		{
			//redirect them to the auth page
			$msg = $this->ion_auth->messages();
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/usuario", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$msg = $this->ion_auth->errors();
			$tipo = 'error';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/usuario/recuperar_clave", 'refresh');
		}
	}//activar
	
	//desactivar
	function desactivar($Id_usuario = NULL)
	{
		// no funny business, force to integer
		$Id_usuario = (int) $Id_usuario;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'Confirmación', 'required');
		$this->form_validation->set_rules('Id_usuario', 'Id de usuario', 'required|is_natural');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$cv['csrf'] = $this->_get_csrf_nonce();
			$cv['usuario'] = $this->ion_auth->get_user_array($Id_usuario);
			
			$tv['title'] 			= 'Recuperar clave';
			$tv['content'][] 		= $this->load->view('administracion/usuario/desactivar', $cv, true); 
			$this->load->view('administracion/template', $tv);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $Id_usuario != $this->input->post('Id_usuario'))
				{
					show_404();
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($Id_usuario);
				}
			}

			//redirect them back to the auth page
			redirect('administracion/usuario', 'refresh');
		}
	}//desactivar
	
	//crear_usuario
	function crear_usuario()
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
			redirect('administracion/usuario', 'refresh');
			
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		if(validation_errors()) $messages[] = validation_errors();

		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Apellido', 'Apellido', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Clave', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Confirmar clave', 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('Nombre')) . ' ' . strtolower($this->input->post('Apellido'));
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$additional_data = array('Nombre' => $this->input->post('Nombre'),
				'Apellido' => $this->input->post('Apellido')
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			$msg = "Usuario creado";
			$tipo = 'exito';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/usuario", 'refresh');
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
			$cv['messages']		= $messages;

			$cv['Nombre'] = array('name' => 'Nombre',
				'id' => 'Nombre',
				'type' => 'text',
				'value' => $this->form_validation->set_value('Nombre'),
			);
			$cv['Apellido'] = array('name' => 'Apellido',
				'id' => 'Apellido',
				'type' => 'text',
				'value' => $this->form_validation->set_value('Apellido'),
			);
			$cv['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$cv['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$cv['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			$tv['title'] 			= 'Crear usuario';
			$tv['content'][] 		= $this->load->view('administracion/usuario/crear_usuario', $cv, true); 
			$this->load->view('administracion/template', $tv);
		}
	}//crear_usuario
	

	//Editar
	function editar(){
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
			redirect('administracion/usuario', 'refresh');
			
		$messages = array();
		if($this->session->flashdata('messages')) $messages = $this->session->flashdata('messages');
		
		$Id_usuario = ($this->input->post('Id_usuario'))?$this->input->post('Id_usuario'):$this->uri->segment('4');
		
		//$this->musuario->Id_usuario = $Id_usuario;
		$usuario = $this->ion_auth->get_user($Id_usuario);
		//validate form input
		$this->form_validation->set_rules('Nombre', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('Apellido', 'Apellido', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Clave', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Confirmar clave', 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('Nombre')) . ' ' . strtolower($this->input->post('Apellido'));
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			
			$additional_data = array('Nombre' => $this->input->post('Nombre'),
				'Apellido' => $this->input->post('Apellido')
			);
		}
		if ($this->form_validation->run() == true && update_user($Id_usuario, $additional_data))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			$msg = "Usuario editado con exito";
			$tipo = 'exito';
			$messages[] = array('msg' => $msg, 'tipo' => $tipo);
			$this->session->set_flashdata('messages', $messages);
			redirect("administracion/usuario", 'refresh');
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
			$cv['messages']		= $messages;

			$cv['Nombre'] = array('name' => 'Nombre',
				'id' => 'Nombre',
				'type' => 'text',
				'value' => $usuario->Nombre,
			);
			$cv['Apellido'] = array('name' => 'Apellido',
				'id' => 'Apellido',
				'type' => 'text',
				'value' => $usuario->Apellido,
			);
			$cv['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $usuario->email,
			);
			$cv['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => '',
			);
			$cv['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => '',
			);
			$cv['Id_usuario'] = array('name' => 'Id_usuario',
				'id' => 'Id_usuario',
				'type' => 'hidden',
				'value' => $usuario->Id_usuario,
			);
			$tv['title'] 			= 'Editar usuario';
			$tv['content'][] 		= $this->load->view('administracion/usuario/editar', $cv, true); 
			$this->load->view('administracion/template', $tv);
		}
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
	
	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}
	
	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}//Editar
	
	
}

/* End of file administracion/usuario.php */
/* Location: ./tekemate/controllers/administracion/usuario.php */