<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mvideo extends CI_Model {

//PROPIEDADES
	var $tabla = 'Video';
	var $ID_video;
	var $ID_categoria_video;
	var $Nombre;
	var $Alias;
	var $Descripcion;
	var $Video_ID;
	var $ID_proveedor_video;
	var $ID_media; //Thumbnail
	var $Fecha_publicacion;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios videos
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		$this->db->select('v.*, m.*, cv.Nombre AS Nombre_categoria, pv.Nombre AS Nombre_proveedor, pv.Embed_URL')
				 ->join('Media AS m', 'm.ID_media = v.ID_media')
				 ->join('Proveedor_video AS pv', 'pv.ID_proveedor_video = v.ID_proveedor_video')
				 ->join('Categoria_video AS cv', 'cv.ID_categoria_video = v.ID_categoria_video');
		if($this->ID_video) $this->db->where('ID_video', $this->ID_video);
		if($this->ID_categoria_video) $this->db->where('v.ID_categoria_video', $this->ID_categoria_video);

		$this->db->where('v.Activo', 1)->limit($cantidad,$desde);
		$this->db->order_by('v.Fecha_publicacion', 'DESC');

		$Q = $this->db->get($this->tabla . ' AS v');
		
		//Si la consulta devuelve 1 o mas resultados
		if($Q->num_rows() > 0)
			return $Q->result();
		else
		//Si no retorno falso
			return false;	
	}//obtener
	
/**
 * Obtiene la información de un video
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		if($this->Video_ID)
			$this->db->where('Video_ID', $this->Video_ID);
		if($this->ID_video)
			$this->db->where('ID_video', $this->ID_video);
			
		$this->db->join('Media AS m', 'm.ID_media = v.ID_media');
		
		$this->db->where('v.Activo', 1);
		$Q = $this->db->get($this->tabla . ' AS v');
		
	//Si la consulta devuelve 1 resultado
		if($Q->num_rows() == 1)
			return $Q->row();
		else
		//Si no retorno falso
			return false;	
	}//obtener_uno
	
/**
 * Añade un nuevo video
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){
		$datos = array( 'Nombre' 			=> $this->Nombre,
						'Alias' 			=> $this->Alias,
						'ID_categoria_video'=> $this->ID_categoria_video,
						'Descripcion'		=> $this->Descripcion,
						'Video_ID' 			=> $this->Video_ID,
						'ID_proveedor_video'=> $this->ID_proveedor_video,
						'ID_media' 			=> $this->ID_media,
						'Fecha_publicacion'	=> $this->Fecha_publicacion,
						'Activo' 			=> $this->Activo
					  );
	
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un video existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Alias) $this->db->set('Alias', $this->Alias);
		if($this->ID_categoria_video) $this->db->set('ID_categoria_video', $this->ID_categoria_video);
		if($this->Descripcion) $this->db->set('Descripcion', $this->Descripcion);
		if($this->Video_ID) $this->db->set('Video_ID', $this->Video_ID);
		if($this->ID_proveedor_video) $this->db->set('ID_proveedor_video', $this->ID_proveedor_video);
		if($this->ID_media) $this->db->set('ID_media', $this->ID_media);
		if($this->Fecha_publicacion) $this->db->set('Fecha_publicacion', $this->Fecha_publicacion);
		if($this->Activo == 1 || $this->Activo == 0) $this->db->set('Activo', $this->Activo);

		if($this->ID_video){ 
			$this->db->where('ID_video', $this->ID_video);
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
		if($this->ID_video){
			if($this->ID_video) $this->db->where('ID_video', $this->ID_video);
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
		if($this->ID_video) $this->db->where('ID_video', $this->ID_video);
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
		$this->ID_video				= NULL;
		$this->Nombre				= NULL;
		$this->Alias				= NULL;
		$this->ID_categoria_video	= NULL;
		$this->Descripcion 			= NULL;
		$this->Video_ID				= NULL;
		$this->ID_proveedor_video	= NULL;
		$this->ID_media				= NULL;
		$this->Fecha_publicacion	= NULL;
		$this->Activo	 			= NULL;
	}//clear


}
/* End of file Mvideo.php */
/* Location: ./tekemate/models/mvideo.php */