<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mcategoria_video extends CI_Model {

//PROPIEDADES
	var $tabla = 'Categoria_video';
	var $ID_categoria_video;
	var $Nombre;
	var $Alias;
	var $Descripcion;
	var $Orden;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios categoria_videos
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		
		if($this->ID_categoria_video) $this->db->where('ID_categoria_video', $this->ID_categoria_video);
		//$this->db->join('Video AS v', 'cv.ID_categoria_video = v.ID_categoria_video');

		$this->db->where('cv.Activo', 1)->limit($cantidad,$desde);
		$this->db->order_by('ABS(Orden)', 'ASC');

		$Q = $this->db->get($this->tabla . ' AS cv');
		
		//Si la consulta devuelve 1 o mas resultados
		if($Q->num_rows() > 0)
			return $Q->result();
		else
		//Si no retorno falso
			return false;	
	}//obtener
	
/**
 * Obtiene la información de un categoria_video
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		if($this->ID_categoria_video)
			$this->db->where('ID_categoria_video', $this->ID_categoria_video);
		if($this->Alias)
			$this->db->where('Alias', $this->Alias);
		
		$this->db->where('cv.Activo', 1);
		$Q = $this->db->get($this->tabla . ' AS cv');
		
	//Si la consulta devuelve 1 resultado
		if($Q->num_rows() == 1)
			return $Q->row();
		else
		//Si no retorno falso
			return false;	
	}//obtener_uno
	
/**
 * Añade un nuevo categoria_video
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){
		$datos = array( 'Nombre' 		=> $this->Nombre,
						'Alias' 		=> $this->Alias,
						'Descripcion'	=> $this->Descripcion,
						'Orden' 		=> $this->Orden,
						'Activo' 		=> $this->Activo
					  );
		
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un categoria_video existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Alias) $this->db->set('Alias', $this->Alias);
		if($this->Descripcion) $this->db->set('Descripcion', $this->Descripcion);
		if($this->Orden) $this->db->set('Orden', $this->Orden);
		if($this->Activo == 1 || $this->Activo == 0) $this->db->set('Activo', $this->Activo);
		
		if($this->ID_categoria_video){ 
			$this->db->where('ID_categoria_video', $this->ID_categoria_video);
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
		if($this->ID_categoria_video){
			if($this->ID_categoria_video) $this->db->where('ID_categoria_video', $this->ID_categoria_video);
			$Q = $this->db->delete($this->tabla);
			return $Q;
		}else return false;
	}//delete
	
/**
 * Reordena todos los registros respecto al parámetro dado
 * 
 * @author Victor Arias
 * @access public
 * @return Bool
 */	
 
 	function reordenar($orden){
		if($this->ID_categoria_video){
			$this->db->where('ID_categoria_video <> ', $this->ID_categoria_video);
		}
		$this->db->set('Orden', 'Orden+1', FALSE)
		->where('Orden >= ', $orden);
		
		$Q = $this->db->update($this->tabla);
		return $Q;
		
	}//reordenar
	
/**
 * Obtiene el número total de registros a listar
 * 
 * @author Victor Arias
 * @access public
 * @return Bool
 */	
 
 	function count(){
		if($this->ID_categoria_video) $this->db->where('ID_categoria_video', $this->ID_categoria_video);
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
		$this->ID_categoria_video= NULL;
		$this->Nombre			= NULL;
		$this->Alias			= NULL;
		$this->Descripcion 		= NULL;
		$this->Orden			= NULL;
		$this->Activo	 		= NULL;
	}//clear


}
/* End of file Mcategoria_video.php */
/* Location: ./tekemate/models/mcategoria_video.php */