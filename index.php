<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$segments = explode("/", $path);
$action = $segments[2];
$controller = $segments[1];

require "src/controllers/$controller.php";
$controller_object = new $controller;
$controller_object->$action();
