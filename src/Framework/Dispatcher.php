<?php
namespace Framework;
use ReflectionClass;
use ReflectionMethod;

class Dispatcher
{
    public function __construct(private Router $router)
    {
    }

    public function handle(string $path): void
    {
        $params = $this->router->match($path);
        if($params === false)
            exit("No route matched");

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        // Use reflector to get params of Controller constructor, that we need to provide while instanciates the Controller.
        // Because we don't know how many params and what exactly we have to provide here.
        $reflector = new ReflectionClass($controller);
        $constructor = $reflector->getConstructor();
        $dependencies = [];
        if($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                $type = (string) $param->getType();
                $dependencies[] = new $type;
            }
        }

        // Auto wiring
        // Creating any dependencies automatically based on the type declarations in the controller
        $controller_object = new $controller(...$dependencies); // unpack array of dependencies instead of give specific params
        $args = $this->getActionArguments($controller, $action, $params);;
        $controller_object->$action(...$args);
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