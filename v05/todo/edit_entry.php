<?php
if(Helper::checkLogin(true)){
	
	if (!isset($_POST['todoId'], $_POST['title'], $_POST['priority'], $_POST['deadline'])) {
	    die("INVALID_FORM");
	}
	
	if (($todoId = trim($_POST['todoId'])) === '' OR
		($title = trim($_POST['title'])) === '' OR
	    ($priority = trim($_POST['priority'])) === '' OR
		($deadline = trim($_POST['deadline'])) === '') {
	    die("EMPTY_FORM");
	}
	
	$todo = TodoEntryRepository::loadByID($todoId);
	
	$todo->setTitle(htmlspecialchars($title));
	$todo->setPriority($priority);
	$todo->setDeadline(new DateTime($deadline));
	$todo->setCreator(Helper::getCurrentUserId());
	
	if(TodoEntryRepository::save($todo)){
		header('Location: main.php?page=overview');
	} else {
		echo "Could not update Todo";
	}
}
?>