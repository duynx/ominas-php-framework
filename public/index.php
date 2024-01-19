<?php
declare(strict_types=1);

require_once dirname(__DIR__, 1).'/vendor/autoload.php';

define("ROOT_PATH", dirname(__DIR__));

$dotEnv = new Framework\DotEnv();
$dotEnv->load(ROOT_PATH . "/.env");

set_error_handler("Framework\ErrorHandler::handleError");
set_exception_handler("Framework\ErrorHandler::handleException");

$router = require ROOT_PATH. "/config/routes.php";
$container = require ROOT_PATH. "/config/services.php";
$middleware = require ROOT_PATH . "/config/middleware.php";
$dispatcher = new Framework\Dispatcher($router, $container, $middleware);
$request = Framework\Request::createFromGlobals();
$response = $dispatcher->handle($request);
$response->send();