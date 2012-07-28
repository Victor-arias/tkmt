<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*************************************************
 * Created on 25/09/2009
 * By Victor Arias
 * 
 * Extensión de la clase Config de CodeIgniter
 * Necesito añadir el método set_item con el parámetro de un índice adicional...
 ************************************************/
class MY_Config extends CI_Config {
	
	public function __construct(){
        parent::__construct();
    }
	
	/**
	 * Set a config file item
	 *
	 * @access	public
	 * @param	string	the config item key
	 * @param	string	the config item value
	 * @param	string	the index name
	 * @return	void
	 */
	function set_item($item, $value, $index = '')
	{
		echo 'valor '.$value;
		if ($index == '')
		{	
			if ( ! isset($this->config[$item]))
			{
				echo 'no1';
				return FALSE;
			}
			$this->config[$item] = $value;
			echo 'maso '.$value;
		}
		else
		{
			if ( ! isset($this->config[$index]))
			{
				echo 'no2';
				return FALSE;
			}

			if ( ! isset($this->config[$index][$item]))
			{
				echo 'no3';
				return FALSE;
			}
			$this->config[$index][$item] = $value;
			echo 'si '.$value;
		}
	}

}

// END CI_Config class

/* End of file Config.php */
/* Location: ./system/libraries/Config.php */