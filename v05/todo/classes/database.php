<?php

class Database {
	
	const DATABASE = "todoApp";
	const SERVERNAME = "localhost";
	const DB_USER = "todoAppUser";
	const DB_USER_PASSWORD = "test1234"; 

    private static $db = null;
    private $connection;
	

    private function __construct() {
    	$dsn = 'mysql:dbname='. Database::DATABASE .';host=' . Database::SERVERNAME . ';charset=utf8';
		$dbuser=Database::DB_USER;
		$dbpass=Database::DB_USER_PASSWORD;
		try {
		    $this->connection = new PDO($dsn, $dbuser, $dbpass);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}		
    }

	/**
	 * @return PDO 
	 */
    public static function getConnection() {
        if (static::$db == null) {
            static::$db = new Database();
        }
        return static::$db->connection;
    }
	
}
?>