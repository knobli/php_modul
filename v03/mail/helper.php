<?php
class Helper {
	/**
	 * use this to prent formmail spamming
	 */ 
	public static function stripLineBreaks($val) {
		$val = preg_replace("/([\r\n])/", "", $val);
		return $val;
	}
	
	public static function correctErrors($text,$replaceReturns = true){
		$text = str_replace("Ä", "&Auml;", $text);
		$text = str_replace("Ö", "&Ouml;", $text);
		$text = str_replace("Ü", "&Uuml;", $text);
		$text = str_replace("ä", "&auml;", $text);
		$text = str_replace("ö", "&ouml;", $text);
		$text = str_replace("ü", "&uuml;", $text);
		$text = str_replace("ë", "&euml;", $text);
		$text = str_replace("\\\"", "\"", $text);
		$text = str_replace("\\\'", "\'", $text);
		$text = str_replace("\\\]", "]", $text);
		$text = str_replace("\\\[", "[", $text);
		$text = str_replace("\'", "&prime;", $text);
		if($replaceReturns){
			$text=nl2br($text);
		}
		
		return $text;
	}	
}
?>