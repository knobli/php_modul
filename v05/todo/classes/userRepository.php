<?php
class UserRepository {

	/**
	 * @param string $name
	 * @return User
	 */	
    public static function loadByName( $name ) {
    	$instance = new User();
    	try{
	    	$db = Database::getConnection();
			$sql = 'SELECT 
						id, password
					FROM
						users
					WHERE
						username = :name';		
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->bindColumn(1, $id);
    		$stmt->bindColumn(2, $password);
			if($stmt->fetch()) {
				$instance->setId($id);	
				$instance->setUsername($name);
				$instance->setPassword($password);	
			} else {
				$instance = null;
			}		
		} catch(PDOException $pdoException){
			Logger::getLogger()->logFatal("loadByName: " . $pdoException->getMessage());
			$instance = null;
		}

		return $instance; 
	}

	/**
	 * @param int $id
	 * @return User
	 */	
    public static function loadById( $id ) {
    	$instance = new User();
    	try{
	    	$db = Database::getConnection();
			$sql = 'SELECT 
						username, password
					FROM
						users
					WHERE
						id = :id';		
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->bindColumn(1, $name);
    		$stmt->bindColumn(2, $password);
			if($stmt->fetch()) {
				$instance->setId($id);	
				$instance->setUsername($name);
				$instance->setPassword($password);	
			} else {
				$instance = null;
			}		
		} catch(PDOException $pdoException){
			Logger::getLogger()->logFatal("loadByID: " . $pdoException->getMessage());
			$instance = null;
		}

		return $instance; 
	}
	
}
?>