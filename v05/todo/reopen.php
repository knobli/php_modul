<?php if(Helper::checkLogin(true)){

	if (!isset($_GET['todoId'])) {
	    die("INVALID_FORM");
	}
	
	if (($todoId = trim($_GET['todoId'])) === '') {
	    die("EMPTY_FORM");
	}
	 
	$todo = TodoEntryRepository::loadByID($todoId);
	$todo->reopen();
	
	if(TodoEntryRepository::save($todo)){
		header('Location: main.php?page=history');
	} else {
		echo "Could not update Todo";
	}

}
?>