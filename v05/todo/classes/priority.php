<?php
define('LOW', 1);
define('MEDIUM', 2);
define('HIGH', 3);

class Priority {
	
	private static $priorities = array(
	  LOW => "low",
	  MEDIUM   => "medium",
	  HIGH => "high"
	);
	
	public static function getPriorityString($priority){
		return self::$priorities[$priority];
	}
	
	public static function getPriorities(){
		return self::$priorities;
	}								
   
}
?>