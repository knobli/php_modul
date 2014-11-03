<?php
class Schweizer extends Mensch {
	
	function __construct($name, $sex){
		parent::__construct($name, $sex);
	}
	
	function umbennen($name){
		parent::umbennen($name);
		$this->behoerdengang();
	}
	
	function behoerdengang(){
		throw new Exception("Der Geduldsfaden ist gerissen!");
	}
}
?>