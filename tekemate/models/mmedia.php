<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmedia extends CI_Model {

//PROPIEDADES
	var $tabla = 'Media';
	var $ID_media;
	var $Tipo;
	var $Url;
	var $Texto_alternativo;
	var $Ancho;
	var $Alto;
	var $Subido;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios medias
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		
		if($this->ID_media) $this->db->where('ID_media', $this->ID_media);
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
 * Obtiene la información de un media
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		if($this->ID_media)
			$this->db->where('ID_media', $this->ID_media);
		
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
 * Añade un nuevo media
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){
		$datos = array( 'Tipo' 			=> $this->Tipo,
						'Url'	 		=> $this->Url,
						'Texto_alternativo'	 => $this->Texto_alternativo,
						'Ancho' 		=> $this->Ancho,
						'Alto' 			=> $this->Alto,
						'Subido' 		=> $this->Subido,
						'Activo' 		=> $this->Activo
					  );
		
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un media existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		
		if($this->Nombre) $this->db->set('Tipo', $this->Tipo);
		if($this->Url) $this->db->set('Url', $this->Url);
		if($this->Texto_alternativo) $this->db->set('Texto_alternativo', $this->Texto_alternativo);
		if($this->Ancho) $this->db->set('Ancho', $this->Ancho);
		if($this->Alto) $this->db->set('Alto', $this->Alto);
		if($this->Subido) $this->db->set('Subido', $this->Subido);
		if($this->Activo) $this->db->set('Activo', $this->Activo);
		
		if($this->ID_media){ 
			$this->db->where('ID_media', $this->ID_media);
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
		if($this->ID_media){
			if($this->ID_media) $this->db->where('ID_media', $this->ID_media);
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
		if($this->ID_media) $this->db->where('ID_media', $this->ID_media);
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
		$this->ID_media			= NULL;
		$this->Tipo		 		= NULL;
		$this->Url			 	= NULL;
		$this->Texto_alternativo= NULL;
		$this->Ancho			= NULL;
		$this->Alto		 		= NULL;
		$this->Subido	 		= NULL;
		$this->Activo	 		= NULL;
	}//clear


}
/* End of file Mmedia.php */
/* Location: ./tekemate/models/mmedia.php */