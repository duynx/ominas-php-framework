<?php
declare(strict_types=1);

namespace Framework;
use ReflectionMethod;
use Framework\Exceptions\PageNotFoundException;

class Dispatcher
{
    public function __construct(private Router $router, private Container $container)
    {}

    public function handle(string $path, string $method)
    {
        $params = $this->router->match($path, $method);

        if($params === false) {
            throw new PageNotFoundException("No route matched for '$path' with method '$method'");
        }

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $controllerObject = $this->container->get($controller);

        $args = $this->getActionArguments($controller, $action, $params);;
        $controllerObject->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = [];

        $method = new ReflectionMethod($controller, $action);
        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();
            $args[$name] = $params[$name];
        }

        return $args;
    }

    private function getControllerName(array $params): string
    {
        $controller = $params["controller"];
        $controller = str_replace("-","",ucwords(strtolower($controller), "-"));

        $namespace = "App\Controllers";
        if(array_key_exists("namespace", $params)) {
            $namespace .= "\\" . $params["namespace"];
        }

        return $namespace. "\\" . $controller;
    }

    private function getActionName(array $params): string
    {
        $action = $params["action"];
        return lcfirst(str_replace("-","", ucwords(strtolower($action),"-")));
    }
}