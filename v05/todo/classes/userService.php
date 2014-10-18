<?php
class UserService {

	/**
	 * @return bool
	 */
	public static function login(User $user, $password){
		try{
	    	$db = Database::getConnection();
			$passwordHash = md5(md5($user->getId()).$password);
			$sql = 'SELECT
						password
					FROM
						users
					WHERE
						id = :id 
					AND
						password = :password';		
			$stmt = $db->prepare($sql);
			$userId = $user->getId();
			$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
			$stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->execute();
			if(!$stmt->fetch(PDO::FETCH_ASSOC)){
				Logger::getLogger()->logError("Das eingegebene Password von " . $user->getUsername() . " ist ungültig.");
				return false;
			}
		} catch (PDOException $pdoException){
			Logger::getLogger()->logFatal("login: " . $pdoException->getMessage());
			return false;
		}
		return true;
	}	
	
}
