<?php
class Helper {	
	const LOGIN_FLAG = "login";
	const LOGIN_USERNAME = "username";
	const LOGIN_USERID = "userId";
	
	public static function checkLogin($redirect = false){
		if(isset($_SESSION[Helper::LOGIN_FLAG]) && $_SESSION[Helper::LOGIN_FLAG] == true) {
			return true;
		} else {
			if($redirect){
				header("Location: main.php?page=overview");
			}
			return false;
		}		
	}
	
	/**
	 * @return string
	 */
	public static function getUsername(){
		return $_SESSION[Helper::LOGIN_USERNAME];		
	}
	
	/**
	 * @return int
	 */
	public static function getCurrentUserId(){
		return $_SESSION[Helper::LOGIN_USERID];		
	}	
	
	/**
	 * @return User
	 */
	public static function getCurrentUser(){
		$userId = $_SESSION[Helper::LOGIN_USERID];
		return UserRepository::loadById($userId);		
	}	
}
?>