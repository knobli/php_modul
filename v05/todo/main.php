<?php
session_start();

date_default_timezone_set('Europe/Zurich');

define("DEBUG", true);

if(DEBUG){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

require 'classes/class_includes.php';

if(isset($_GET['page'])){
	$pageName=$_GET['page'];
} else {
	$pageName='overview';
}
$page=$pageName.".php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todo App</title>
	<meta charset="utf-8" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	
	<link rel="stylesheet" href="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css">
	
	<link rel="stylesheet" href="myStyle.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>
	<script src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/src/js/bootstrap-datetimepicker.js"></script>	
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
	    <div class="navbar-header">	
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="main.php?page=overview">Todo</a>
	    </div>	    		
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
			<li><a href="main.php?page=overview"><span class="glyphicon glyphicon-th-list"></span> Overview</a></li>
			<li><a href="main.php?page=history"><span class="glyphicon glyphicon-time"></span> History</a></li>
		  </ul>
		<?php if(Helper::checkLogin(false)){ ?>			
			<form class="navbar-right navbar-form" action="main.php?page=login" method="post">
				Logged in as: <b><?=Helper::getUsername()?></b>
				<input type="submit" name="logout" value="Logout">
			</form>
		<?php } ?>
		</div>
	</nav>
	<div class="container">
		<?php include "$page"; ?>
	</div>
</body>
</html>