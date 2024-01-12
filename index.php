<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require "src/router.php";
$router = new Router();
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);

$params = $router->match($path);

if($params === false)
    exit("No route matched");

$segments = explode("/", $path);
$action = $params["action"];
$controller = $params["controller"];

require "src/controllers/$controller.php";
$controller_object = new $controller;
$controller_object->$action();
