<?php if(Helper::checkLogin(true)){
	
	if (!isset($_POST['blogFile'], $_POST['title'], $_POST['content'])) {
	    die("INVALID_FORM");
	}
	
	if (($blogFile = trim($_POST['blogFile'])) === '' OR
		($title = trim($_POST['title'])) === '' OR
	    ($content = trim($_POST['content'])) === '') {
	    die("EMPTY_FORM");
	}
		
	$blogFile = htmlspecialchars($blogFile);

	$filecontent = file(BlogEntry::UPLOAD_DIR . $blogFile);
	$blogEntry = BlogEntry::createFromArray($filecontent);
	
	//only update content and title as described in the exercise
	$blogEntry->setTitle(htmlspecialchars($title));
	$blogEntry->setContent(htmlspecialchars($content));

	file_put_contents(BlogEntry::UPLOAD_DIR . $blogFile, $blogEntry->getOutputForSaving());

	header('Location: main.php?page=overview');
	
}
?>