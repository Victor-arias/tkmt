<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = FALSE)
	{
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
						"á"                     => 'a',
						"é"                     => 'e',
						"í"                     => 'i',
						"ó"                     => 'o',
						"ú"                     => 'u',
						"à"                     => 'a',
						"è"                     => 'e',
						"ì"                     => 'i',
						"ò"                     => 'o',
						"ù"                     => 'u',
						"ñ"                     => 'n',
						"Á"                     => 'a',
						"É"                     => 'e',
						"Í"                     => 'i',
						"Ó"                     => 'o',
						"Ú"                     => 'u',
						"À"                     => 'a',
						"È"                     => 'e',
						"Ì"                     => 'i',
						"Ò"                     => 'o',
						"Ù"                     => 'u',
						"Ñ"                     => 'n',
						"ä"                     => 'a',
						"ë"                     => 'e',
						"ï"                     => 'i',
						"ö"                     => 'o',
						"ü"                     => 'u',
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					);

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(stripslashes($str));
	}
}


/* End of file MY_url_helper.php */
/* Location: ./tekemate/helpers/MY_url_helper.php */