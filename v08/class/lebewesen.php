<?php
abstract class Lebewesen {
	
	protected $alter = 0;
	
	abstract function altern();
	
	function getAlter(){
		return $this->alter;
	}
	
	
}
