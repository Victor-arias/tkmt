<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * script_tag
 * Genera una etiqueta <script> para incluir un archivo JavaScript
 *
 * @access	public
 * @param	mixed	Javascript src o un array
 * @param	string	script para agregar
 * @param	string	tipo
 * @return	string
 */
if ( ! function_exists('script_tag')){
	function script_tag($src = '', $code = '', $type = 'text/javascript'){
		$CI =& get_instance();
		$script = '<script ';
		if (is_array($src)){
			foreach ($src as $k=>$v){
				if ($k == 'src' AND strpos($v, '://') === FALSE){
					$script .= 'src="'.base_url().$v.'" ';
				}else{
					$script .= "$k=\"$v\" ";
				}
			}
			$script .= ">" . $code . "</script>";
		}else{
			if($src != ''){
				if (strpos($src, '://') !== FALSE)	{
					$script .= 'src="'.$src.'" ';
				}else{
					$script .= 'src="'.base_url().$src.'" ';
				}
			}
			$script .= 'type="'.$type.'" ';
			$script .= '>' . $code . '</script>';
		}
		$script .= "\r\n";
		return $script;
	}
}

// ------------------------------------------------------------------------

/**
 * p 
 * Genera una etiqueta p 
 *
 * @access	public
 * @param	boolean true=abierta, false=cerrada
 * @param	string atributos html
 * @return	string
 */
if ( ! function_exists('p'))
{
	function p($lugar=true, $atributos = '')
	{
		if ($lugar == true){
			return ("<p " . $atributos . ">");			
		} else {
			return ("</p>"."\n");
		}
	}
}



?>