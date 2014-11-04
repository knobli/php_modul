<?php
require_once 'FrontController.php';
require_once 'HttpRequest.php';
require_once 'HttpResponse.php';
require_once 'FileSystemCommandResolver.php';
require_once 'autoload.php';

$resolver = new FileSystemCommandResolver('commands');
$f_controller = new FrontController($resolver);
$request = new HttpRequest();
$response = new HttpResponse();
$f_controller->handleRequest($request, $response);


?>