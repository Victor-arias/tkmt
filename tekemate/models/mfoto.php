<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mfoto extends CI_Model {

//PROPIEDADES
	var $tabla = 'Foto';
	var $ID_foto;
	var $ID_foto_album;
	var $Nombre;
	var $Foto;
	var $Thumb;
	var $Fecha_publicacion;
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
		
		$this->db->select('f.*, fa.*, fa.Nombre AS Nombre_album, fa.Alias');
		if($this->ID_foto) $this->db->where('f.ID_foto', $this->ID_foto);
		if($this->ID_foto_album) $this->db->where('f.ID_foto_album', $this->ID_foto_album);
		$this->db->where('f.Activo', 1)->limit($cantidad,$desde);

		$this->db->join('Foto_album AS fa', 'fa.ID_foto_album = f.ID_foto_album');
		
		$Q = $this->db->get($this->tabla . ' AS f');
		
		//Si la consulta devuelve 1 o mas resultados
		if($Q->num_rows() > 0)
			return $Q->result();
		else
		//Si no retorno falso
			return false;	
	}//obtener
	
/**
 * Obtiene la información de una foto
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		if($this->ID_foto)
			$this->db->where('ID_foto', $this->ID_foto);
		/*if($this->Alias)
			$this->db->where('Alias', $this->Alias);*/
		
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

		$datos = array( 'ID_foto_album' => $this->ID_foto_album,
						'Nombre' 		=> $this->Nombre,
						'Foto'	 		=> $this->Foto,
						'Thumb'	 		=> $this->Thumb,
						'Fecha_publicacion' => $this->Fecha_publicacion,
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
		
		if($this->ID_foto_album) $this->db->set('ID_foto_album', $this->ID_foto_album);
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Foto) $this->db->set('Foto', $this->Foto);
		if($this->Thumb) $this->db->set('Thumb', $this->Thumb);
		if($this->Fecha_publicacion) $this->db->set('Fecha_publicacion', $this->Fecha_publicacion);
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