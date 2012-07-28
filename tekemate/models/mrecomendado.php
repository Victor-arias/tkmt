<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mrecomendado extends CI_Model {

//PROPIEDADES
	var $tabla = 'Recomendado';
	var $ID_recomendado;
	var $Nombre;
	var $Video_ID;
	var $ID_proveedor_video;
	var $Fecha_publicacion;
	var $Publicado;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios recomendados
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		
		$this->db->select('r.*, pv.Nombre AS Nombre_proveedor, pv.Embed_URL')
				 ->join('Proveedor_video AS pv', 'pv.ID_proveedor_video = r.ID_proveedor_video');
		if($this->ID_recomendado) $this->db->where('r.ID_recomendado', $this->ID_recomendado);
		$this->db->where('r.Activo', 1)->limit($cantidad,$desde);
		$this->db->order_by('Fecha_publicacion', 'DESC');
		
		$Q = $this->db->get($this->tabla . ' AS r');
		
		//Si la consulta devuelve 1 o mas resultados
		if($Q->num_rows() > 0)
			return $Q->result();
		else
		//Si no retorno falso
			return false;	
	}//obtener
	
/**
 * Obtiene la información de un recomendado
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno($publicado = false){
		
		if($this->ID_recomendado)
			$this->db->where('ID_recomendado', $this->ID_recomendado);
		if($this->Video_ID)
			$this->db->where('Video_ID', $this->Video_ID);
		if($publicado)
			$this->db->where('Publicado',1);
		
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
 * Añade un nuevo recomendado
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){

		$datos = array( 'Nombre' 			=> $this->Nombre,
						'Video_ID' 			=> $this->Video_ID,
						'ID_proveedor_video'=> $this->ID_proveedor_video,
						'Fecha_publicacion'	=> $this->Fecha_publicacion,
						'Publicado'	 		=> $this->Publicado,
						'Activo' 			=> $this->Activo
					  );
		
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un recomendado existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Video_ID) $this->db->set('Video_ID', $this->Video_ID);
		if($this->ID_proveedor_video) $this->db->set('ID_proveedor_video', $this->ID_proveedor_video);
		if($this->Fecha_publicacion) $this->db->set('Fecha_publicacion', $this->Fecha_publicacion);
		if($this->Publicado) $this->db->set('Publicado', $this->Publicado);
		$this->db->set('Activo', $this->Activo);
		
		if($this->ID_recomendado){ 
			$this->db->where('ID_recomendado', $this->ID_recomendado);
			$Q = $this->db->update($this->tabla);
			if($Q) return true;
			else return false;
		}elseif($this->Video_ID){
			$this->db->where('Video_ID', $this->Video_ID);
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
		if($this->ID_recomendado){
			if($this->ID_recomendado) $this->db->where('ID_recomendado', $this->ID_recomendado);
			$Q = $this->db->delete($this->tabla);
			return $Q;
		}else return false;
	}//delete

/**
 * Despublica todos los recomendados excepto el indicado en el parámetro
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function despublicar($ID_recomendado = 0){
		
		$this->db->set('Publicado', 0);
		
		if($ID_recomendado){ 
			$this->db->where('ID_recomendado !=', $ID_recomendado);
		}
		$Q = $this->db->update($this->tabla);
		if($Q) return true;
		else return false;
	}//editar

/**
 * Obtiene el número total de registros a listar
 * 
 * @author Victor Arias
 * @access public
 * @return Bool
 */	
 
 	function count(){
		if($this->ID_recomendado) $this->db->where('ID_recomendado', $this->ID_recomendado);
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
		$this->ID_recomendado		= NULL;
		$this->Nombre	 			= NULL;
		$this->Video_ID		 		= NULL;
		$this->ID_proveedor_video	= NULL;
		$this->Fecha_publicacion	= NULL;
		$this->Publicado		 	= NULL;
		$this->Activo	 			= NULL;
	}//clear


}
/* End of file Mrecomendado.php */
/* Location: ./tekemate/models/mrecomendado.php */