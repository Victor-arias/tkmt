<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mfoto extends CI_Model {

//PROPIEDADES
	var $tabla = 'Foto';
	var $ID_foto;
	var $Nombre;
	var $Foto;
	var $Thumb;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios fotos
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		
		if($this->ID_foto) $this->db->where('ID_foto', $this->ID_foto);
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
 * Obtiene la información de un foto
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		if($this->ID_foto)
			$this->db->where('ID_foto', $this->ID_foto);
		
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
 * Añade un nuevo foto
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){

		$datos = array( 'Nombre' 		=> $this->Nombre,
						'Foto'	 	=> $this->Foto,
						'Thumb'	 		=> $this->Thumb,
						'Activo' 		=> $this->Activo
					  );
		
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un foto existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Foto) $this->db->set('Foto', $this->Foto);
		if($this->Thumb) $this->db->set('Thumb', $this->Thumb);
		if($this->Activo) $this->db->set('Activo', $this->Activo);
		
		if($this->ID_foto){ 
			$this->db->where('ID_foto', $this->ID_foto);
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
		if($this->ID_foto){
			if($this->ID_foto) $this->db->where('ID_foto', $this->ID_foto);
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
		if($this->ID_foto) $this->db->where('ID_foto', $this->ID_foto);
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
		$this->ID_foto			= NULL;
		$this->Nombre	 		= NULL;
		$this->Foto		 	= NULL;
		$this->Thumb		 	= NULL;
		$this->Activo	 		= NULL;
	}//clear


}
/* End of file Mfoto.php */
/* Location: ./tekemate/models/mfoto.php */