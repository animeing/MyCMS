<?php

final class StringUtil {
    private function __construct(){}
	
	const EMPTY_STRING = "";
	const TIME_STAMP_FORMAT = "Y-m-d H:i:s";
	const EMAIL_ADDRESS_PLACEHOLDER = "addess@example.com";
	const BRANK_FILE_NAME_STRING = array('@', '"', '/', '\\', '[', ']', ':', ';', '|', '=', ',');
	
    public static function isNullOrEmpty($variable){
        return (!isset($variable) || $variable == "");
	}
    
	public static function deleteBom($str){
		if (($str == NULL) || (mb_strlen($str) == 0)) {
			return $str;
		}
		if (ord($str{0}) == 0xef && ord($str{1}) == 0xbb && ord($str{2}) == 0xbf) {
			$str = substr($str, 3);
		}
		return $str;
	}

	public static function encloseData($data, $enclose){
		return $enclose.$data.$enclose;
	}

	/**
	 * @param string $html 
	 * @return string
	 */
	public static function removeEOL($html){
		$html = preg_replace('[\r\n|'.PHP_EOL.']', "", $html);
		return $html;
	}

	public static function changeHtmlEOL($data){
		return str_replace(PHP_EOL, '<br>', $data);
	}
	/**
	 * @param string $html 
	 * @return string
	 */
	public static function deleteTab($html){
		return preg_replace('[\t|  ]',"", $html);
	}
	/**
	 * @param string $html 
	 * @return string
	 */
	public static function deleteSlashComment($html){
		return preg_replace('[\s//.*'.PHP_EOL.']',"" , $html);
	}
	/**
	 * @param string $html 
	 * @return string
	 */
	public static function deleteJsDocComment($html){
		return preg_replace("/[\/][\*][\*][^\/]*[\*][\/]/s", "", $html);
	}

	public static function deleteString($remove, $text){		
		return str_replace($remove, '', $text);
	}

	/**
	 * @param string $javascript 
	 * @return string
	 */
	public static function deleteNonCode($javascript){
		return StringUtil::removeEOL(StringUtil::deleteTab(StringUtil::deleteJsDocComment(StringUtil::deleteSlashComment($javascript))));
	}

	public static function deleteNonCss($css){
		return StringUtil::removeEOL(StringUtil::deleteTab($css));
	}

	public static function deleteNonHtml($html){
		return StringUtil::removeEOL(StringUtil::deleteBom($html));
	}

	public static function mtRandString($length = 12){
		return base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
	}

	public static function uniqidString($length = 25){
		return substr(base_convert(md5(uniqid()), 16, 36), 0, $length);
	}

	public static function isMailAddress($mailAddress){
		return filter_var( $mailAddress,  FILTER_VALIDATE_EMAIL);
	}
	
	public static function getStorageSymbolByQuantity($bytes) {
		$symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
		$exp = floor(log($bytes)/log(1024));

		return sprintf('%.2f '.$symbols[$exp], ($bytes/pow(1024, floor($exp))));
	}
}
