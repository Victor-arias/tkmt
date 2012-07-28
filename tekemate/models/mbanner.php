<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mbanner extends CI_Model {

//PROPIEDADES
	var $tabla = 'Banner';
	var $ID_banner;
	var $ID_media;
	var $ID_media_thumb;
	var $Nombre;
	var $Url;
	var $Orden;
	var $Agregado;
	var $Publicado;
	var $Activo;

//MÉTODOS
    function __construct()
    {
        parent::__construct();
    }
	
/**
 * Obtiene la información de uno o varios banners
 * 
 * @author Victor Arias
 * @access public
 * @param Number desde Indica desde que indice se deben obtener los registros, para paginar
 * @param Number cantidad Indica cuantos registros debe devolver la consulta
 * @return Object 
 */	
 
 	function obtener($cantidad = 100, $desde = 0){
		
		if($this->ID_banner) $this->db->where('ID_banner', $this->ID_banner);
		$this->db->select('b.*, m.Tipo, m.Url AS mUrl, m.Texto_alternativo, m.Ancho, m.Alto, m.Subido, mt.Tipo AS tTipo, mt.Url AS tUrl, mt.Texto_alternativo AS tTexto_alternativo, mt.Ancho AS tAncho, mt.Alto AS tAlto, mt.Subido AS tSubido');
		$this->db->join('Media AS m', 'm.ID_media = b.ID_media');
		$this->db->join('Media AS mt', 'mt.ID_media = b.ID_media_thumb');
		$this->db->where('b.Activo', 1)->limit($cantidad,$desde);
		if($this->Publicado)
			$this->db->where('Publicado', $this->Publicado);
		$Q = $this->db->get($this->tabla . ' AS b');
		
		//Si la consulta devuelve 1 o mas resultados
		if($Q->num_rows() > 0)
			return $Q->result();
		else
		//Si no retorno falso
			return false;	
	}//obtener
	
/**
 * Obtiene la información de un banner
 * 
 * @author Victor Arias
 * @access public
 * @return Object 
 */
 
	function obtener_uno(){
		
		$this->db->select('b.*, m.Tipo, m.Url AS mUrl, m.Texto_alternativo, m.Ancho, m.Alto, m.Subido, mt.Tipo AS tTipo, mt.Url AS tUrl, mt.Texto_alternativo AS tTexto_alternativo, mt.Ancho AS tAncho, mt.Alto AS tAlto, mt.Subido AS tSubido');
		$this->db->join('Media AS m', 'm.ID_media = b.ID_media');
		$this->db->join('Media AS mt', 'mt.ID_media = b.ID_media_thumb');
		
		if($this->ID_banner)
			$this->db->where('ID_banner', $this->ID_banner);
		if($this->Publicado)
			$this->db->where('Publicado', $this->Publicado);
		
		$this->db->where('b.Activo', 1);
		$Q = $this->db->get($this->tabla . ' AS b');
		
	//Si la consulta devuelve 1 resultado
		if($Q->num_rows() == 1)
			return $Q->row();
		else
		//Si no retorno falso
			return false;	
	}//obtener_uno
	
/**
 * Añade un nuevo banner
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function agregar(){
		$datos = array( 'ID_media' 		=> $this->ID_media,
						'ID_media_thumb'=> $this->ID_media_thumb,
						'Nombre'	 	=> $this->Nombre,
						'Url'	 		=> $this->Url,
						'Orden' 		=> $this->Orden,
						'Agregado' 		=> $this->Agregado,
						'Publicado' 	=> $this->Publicado,
						'Activo' 		=> $this->Activo
					  );
		
		$Q = $this->db->insert($this->tabla, $datos);
		
		if($Q) return $this->db->insert_id();
		else return false;
	}//agregar

/**
 * Edita un banner existente
 * 
 * @author Victor Arias
 * @access public
 * @return Number 
 */

	function editar(){
		if($this->ID_media) $this->db->set('ID_media', $this->ID_media);
		if($this->ID_media_thumb) $this->db->set('ID_media_thumb', $this->ID_media_thumb);
		if($this->Nombre) $this->db->set('Nombre', $this->Nombre);
		if($this->Url) $this->db->set('Url', $this->Url);
		if($this->Orden) $this->db->set('Orden', $this->Orden);
		if($this->Agregado) $this->db->set('Agregado', $this->Agregado);
		if($this->Publicado == 1 || $this->Publicado == 0 ) $this->db->set('Publicado', $this->Publicado);
		if($this->Activo == 1 || $this->Activo == 0) $this->db->set('Activo', $this->Activo);
		
		if($this->ID_banner){ 
			$this->db->where('ID_banner', $this->ID_banner);
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
		if($this->ID_banner){
			if($this->ID_banner) $this->db->where('ID_banner', $this->ID_banner);
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
		if($this->ID_banner) $this->db->where('ID_banner', $this->ID_banner);
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
		$this->ID_banner		= NULL;
		$this->ID_media			= NULL;
		$this->ID_media_thumb	= NULL;
		$this->Nombre			= NULL;
		$this->Url			 	= NULL;
		$this->Orden			= NULL;
		$this->Agregado			= NULL;
		$this->Publicado 		= NULL;
		$this->Activo	 		= NULL;
	}//clear


}
/* End of file Mbanner.php */
/* Location: ./tekemate/models/mbanner.php */