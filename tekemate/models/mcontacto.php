<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mcontacto extends CI_Model {

//PROPIEDADES
	var $tabla = 'Contacto';
	var $ID_contacto;
	var $Nombre;
	var $Cargo;
	var $Celular;
	var $Email;
	var $Email_personal;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios contactos
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		
		if($this->ID_contacto) $this->db->where('ID_contacto', $this->ID_contacto);
		$this->db->where('Activo', 1)->limit($cantidad,$desde);
		
		$Q = $this->db->get($this->tabla);
		
		//Si la consulta devuelve 1 o mas resultados
		if($Q->num_rows() > 0)
			return $Q->result();
		else
		//Si no retorno falso
			return false;	
	}//obtener
	
/**
 * Obtiene la información de un contacto
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		if($this->ID_contacto)
			$this->db->where('ID_contacto', $this->ID_contacto);
		
		$this->db->where('Activo', 1);
		$Q = $this->db->get($this->tabla);
		
	//Si la consulta devuelve 1 resultado
		if($Q->num_rows() == 1)
			return $Q->row();
		else
		//Si no retorno falso
			return false;	
	}//obtener_uno
	
/**
 * Añade un nuevo contacto
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){

		$datos = array( 'Nombre' 		=> $this->Nombre,
						'Cargo' 		=> $this->Cargo,
						'Celular'		=> $this->Celular,
						'Email'	 		=> $this->Email,
						'Email_personal'=> $this->Email_personal,
						'Activo' 		=> $this->Activo
					  );
		
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un contacto existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Cargo) $this->db->set('Cargo', $this->Cargo);
		if($this->Celular) $this->db->set('Celular', $this->Celular);
		if($this->Email) $this->db->set('Email', $this->Email);
		if($this->Email_personal) $this->db->set('Email_personal', $this->Email_personal);
		if($this->Activo) $this->db->set('Activo', $this->Activo);
		
		if($this->ID_contacto){ 
			$this->db->where('ID_contacto', $this->ID_contacto);
			$Q = $this->db->update($this->tabla);
		
			if($Q) return true;
			else return false;
		}else return false;
	}//editar
	
/**
 * Elimina un registro
 * 
 * @author Victor Arias
 * @access public
 * @return Bool
 */	
 
 	function delete(){
		if($this->ID_contacto){
			if($this->ID_contacto) $this->db->where('ID_contacto', $this->ID_contacto);
			$Q = $this->db->delete($this->tabla);
			return $Q;
		}else return false;
	}//delete
	
/**
 * Obtiene el número total de registros a listar
 * 
 * @author Victor Arias
 * @access public
 * @return Bool
 */	
 
 	function count(){
		if($this->ID_contacto) $this->db->where('ID_contacto', $this->ID_contacto);
		$this->db->where('Activo', 1);
		$Q = $this->db->count_all_results($this->tabla);
		return $Q;
	}//count
	
/**
 * Obtiene el número total de registros
 * 
 * @author Victor Arias
 * @access public
 * @return Bool
 */	
 
 	function count_all(){
		$Q = $this->db->count_all_results($this->tabla);
		return $Q;
	}//count_all
	
/**
 * Método que limpia las propiedades de este modelo
 * 
 * @author Victor Arias
 * @access public 
 */	 
	function clear(){
		$this->ID_contacto		= NULL;
		$this->Nombre	 		= NULL;
		$this->Cargo		 	= NULL;
		$this->Celular			= NULL;
		$this->Email		 	= NULL;
		$this->Email_personal 	= NULL;
		$this->Activo	 		= NULL;
	}//clear


}
/* End of file Mcontacto.php */
/* Location: ./tekemate/models/mcontacto.php */