<?php
class User {
	
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $username;
	
	/**
	 * @var int
	 */
	private $password;
	

	public function __construct() {
		$this->id = null;
		$this->username = "";
		$this->password = "";
	}		

	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}	
	
	public function getPassword(){
		return $this->password;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}								
   
}
?>