<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<link href="css/css_reset.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
		<title>Page Title</title>
	</head>
	<body>
		<header>
			<h1>h1.title</h1>
			<nav>
				<?php include 'navigation.php' ?>
			</nav>
		</header>
		<div id="content">
			<div id="left">
				<?php include'home.php' ?>
			</div>
			<aside>
				<?php include'aside.php' ?>
			</aside>
		</div>
		<footer>
			footer
		</footer>
	</body>
</html>