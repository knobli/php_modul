<?php
class TodoEntryRepository {

	public static function loadOpenTodos(User $user){
		$todoList=array();
		try{
  			$db = Database::getConnection();
			$sql = 'SELECT
						id
					FROM
						todos
					Where
						creator = :creator
					AND
						status = :status
					Order by deadline ASC, priority ASC';		
			$stmt = $db->prepare($sql);
			$userId = $user->getId();	
			$stmt->bindParam(':creator', $userId, PDO::PARAM_INT);
			$todoStatus = TodoEntry::OPEN;
			$stmt->bindParam(':status', $todoStatus, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->bindColumn(1, $todoId);
			while($stmt->fetch()) {
				$todoList[]=TodoEntryRepository::loadByID($todoId);
			}
		} catch (PDOException $pdoException){
			Logger::getLogger()->logFatal("loadOpenTodos: " . $pdoException->getMessage());
		}		

		return $todoList;		
	}
	
	public static function loadClosedTodos(User $user){
		$todoList=array();
		try{
  			$db = Database::getConnection();
			$sql = 'SELECT
						id
					FROM
						todos
					Where
						creator = :creator
					AND
						status = :status
					Order by deadline DESC, priority ASC';		
			$stmt = $db->prepare($sql);
			$userId = $user->getId();	
			$stmt->bindParam(':creator', $userId, PDO::PARAM_INT);
			$todoStatus = TodoEntry::CLOSED;
			$stmt->bindParam(':status', $todoStatus, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->bindColumn(1, $todoId);
			while($stmt->fetch()) {
				$todoList[]=TodoEntryRepository::loadByID($todoId);
			}
		} catch (PDOException $pdoException){
			Logger::getLogger()->logFatal("loadOpenTodos: " . $pdoException->getMessage());
		}		

		return $todoList;		
	}	

	/**
	 * @param int $id
	 * @return TodoEntry
	 */	
    public static function loadByID( $id ) {
		$instance = new TodoEntry();
		try{
			$db = Database::getConnection();
			$sql = 'SELECT 
						id, title, created, creator, deadline, status, priority
					FROM
						todos
					WHERE
						id = :id';		
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->bindColumn(1, $id);
			$stmt->bindColumn(2, $title);
			$stmt->bindColumn(3, $created);		
			$stmt->bindColumn(4, $creator);
			$stmt->bindColumn(5, $deadline);
			$stmt->bindColumn(6, $status);
			$stmt->bindColumn(7, $priortiy);				
			if($stmt->fetch()) {
				$instance->setId($id);
				$instance->setTitle($title);
				$instance->setCreated(new DateTime($created));
				$instance->setCreator($creator);
				$instance->setDeadline(new DateTime($deadline));
				$instance->setStatus($status);
				$instance->setPriority($priortiy);		
			} else {
				$instance = null;
			}
		} catch (PDOException $pdoException){
			Logger::getLogger()->logFatal("loadByID: " . $pdoException->getMessage());
			$instance = null;
		}		
		return $instance; 
	}
	
	public static function save(TodoEntry $todoEntry){
		try{
			$db = Database::getConnection();
			$title = $todoEntry->getTitle();
			$created = $todoEntry->getCreatedSql();
			$creator = $todoEntry->getCreator();
			$status = $todoEntry->getStatus();
			$priority = $todoEntry->getPriority();
			$deadline = $todoEntry->getDeadlineSql();
			if($todoEntry->getId() === null){
				$sql = 'INSERT INTO
							todos(title, created, creator, status, priority, deadline)
						VALUES
							(:title, :created, :creator, :status, :priority, :deadline)';
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':title', $title, PDO::PARAM_STR);
				$stmt->bindParam(':created', $created, PDO::PARAM_STR);
				$stmt->bindParam(':creator', $creator, PDO::PARAM_INT);
				$stmt->bindParam(':status', $status, PDO::PARAM_INT);
				$stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
				$stmt->bindParam(':deadline', $deadline, PDO::PARAM_STR);
				$stmt->execute();
				$todoEntry->setId($db->lastInsertId());
				return true;			
			} else {
				$sql = 'Update todos
						Set
							title = :title, 
							created = :created, 
							creator = :creator, 
							status = :status, 
							priority = :priority, 
							deadline = :deadline
						Where
							id = :id';
				$stmt = $db->prepare($sql);
				$id = $todoEntry->getId();
				$stmt->bindParam(':title', $title, PDO::PARAM_STR);
				$stmt->bindParam(':created', $created, PDO::PARAM_STR);
				$stmt->bindParam(':creator', $creator, PDO::PARAM_INT);
				$stmt->bindParam(':status', $status, PDO::PARAM_INT);
				$stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
				$stmt->bindParam(':deadline', $deadline, PDO::PARAM_STR);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
				return true;			
			}
		} catch (PDOException $pdoException){
			Logger::getLogger()->logFatal("save: " . $pdoException->getMessage());
			return false;
		}		
	}
	
	public static function delete(TodoEntry $todoEntry){
		try{
			$db = Database::getConnection();
			$sql = 'DELETE FROM
						todos
					WHERE
						id = :id';
			$stmt = $db->prepare($sql);
			$id = $todoEntry->getId();
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return true;
		} catch (PDOException $pdoException){
			Logger::getLogger()->logFatal("delete: " . $pdoException->getMessage());
			return false;
		}						
	}
	
}
?>