<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$action = $_GET['action'];
$controller = $_GET['controller'];

require "src/controllers/$controller.php";

$controller_object = new $controller;

$controller_object->$action();
