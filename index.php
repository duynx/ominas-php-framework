<?php
declare(strict_types=1);

set_error_handler(function (
    int $errNo,
    string $errStr,
    string $errFile,
    int $errLine
): bool
{
    throw new ErrorException($errStr, 0, $errNo, $errFile, $errLine);
});

set_exception_handler(function (Throwable $exception) {
    $showError = true;
    if($showError) {
        ini_set('display_errors', '1');
    }else{
        ini_set('display_errors', '0');
        ini_set("log_errors", "1");
        require "views/500.php";
    }
    throw $exception;
});

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if($path === false) {
    throw new UnexpectedValueException("Malformed URL: '{$_SERVER["REQUEST_URI"]}'");
}

spl_autoload_register(function (string $class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

$router = new Framework\Router();

$router->add("/admin/{controller}/{action}", ["namespace" => "Admin"]);
$router->add("/{title}/{id:\d+}/{page:\d+}", ["controller" => "products", "action" => "showPage"]);
$router->add("/products/{slug:[\w-]+/}", ["controller" => "products", "action" => "show"]);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);
$router->add("/{controller}/{action}");

$container = new Framework\Container;

// We are binding a value for the database class to the service container
$container->set(\App\Database::class,function (){
    return new \App\Database("localhost","ominas","ominas_dbuser","secret");
});

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);