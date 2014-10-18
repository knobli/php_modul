<?php
define("USER", "testUser");
define("PASSWORD", "test1234");

if (isset($_POST['logout'])) {
	session_destroy();
	header('Location: main.php?page=overview');
}

if (isset($_POST['login'])) {
	$user = UserRepository::loadByName($_POST['user']);
	if ($user != null && UserService::login($user, $_POST['password'])) {
		$_SESSION[Helper::LOGIN_USERID] = $user->getId();
		$_SESSION[Helper::LOGIN_USERNAME] = $user->getUsername();
		$_SESSION[Helper::LOGIN_FLAG] = true;
		header('Location: main.php?page=overview');
	} else {
		die("Login failed!");
	}
}

header("Location: main.php?page=overview");
?>