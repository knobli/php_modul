<?php
class Mensch extends Lebewesen {
	
	private static $vorfahre; 
	
	private $name;
	private $sex;
	
	function __construct($name, $sex) {
		$this->name = $name;
		$this->sex = $sex;
		$this->altern();
	}
	
	function __destruct() {
		echo "I'm sorry " . $this->name . " died!";
	}
	
	function altern(){
		$this->alter++;	
	}
	
	function getName(){
		return $this->name;
	}
	
	function umbennen($name){
		$this->name = $name;
	}
	
	function geburtstagFeiern(){
		$this->altern();
		echo "Happy Birthday zum " . $this->getAlter() . ". Geburtstag!";
	}
	
	function neueEvolutionstheorie($vorfahre){
		self::$vorfahre = $vorfahre;
	}
	
	function getVorfahre(){
		return self::$vorfahre;
	}
	
}
?>