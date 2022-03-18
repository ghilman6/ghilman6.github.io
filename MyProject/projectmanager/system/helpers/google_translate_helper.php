<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package CodeIgniter
* @author Tommy Sinaryuda
* @link http://codeigniter.com
* @since Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* CodeIgniter Google Translate Helpers
*
* @package CodeIgniter
* @subpackage Helpers
* @category Helpers
* @author Tommy Sinaryuda
// On date 28-09-2010

*/

// ------------------------------------------------------------------------

/**
* Google Translate Helper
*
* $f - format source language (text, html)
* $s - default source language ( en - English )
* $d - Destination language ( fr - French , sp - Spanish ... )
* Converted the string using google translate API.
* @return string
*/

if ( ! function_exists('google_translate'))
{
function google_translate($text,$d = 'en',$s = 'id',$f='text')
{
	
	if($d=='') $d = $s;
	if($d != $s){
		$lang_pair = urlencode($s.'|'.$d);
		$q = rawurlencode($text);
		// Google's API translator URL
		$url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".$q."&langpair=".$lang_pair."&format=".$f;
		// Make sure to set CURLOPT_REFERER because Google doesn't like if you leave the referrer out
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER,  base_url());
		$body = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($body, true);
		$tranlate = $json['responseData']['translatedText'];
		echo $tranlate;
	} else {
	echo $text;
	}
}
}

// ------------------------------------------------------------------------
/* End of file google_translate_helper.php */
/* Location: ./system/helpers/google_translate_helper.php */