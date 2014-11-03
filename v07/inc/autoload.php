<?php 
	date_default_timezone_set('Europe/Zurich');
	
	$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB,DB_USER,DB_PW);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 ?>