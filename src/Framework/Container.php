<?php
declare(strict_types=1);

namespace Framework;
use Closure;
use Exception;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

class Container
{
    private array $registry = [];

    /**
     * @param string $name
     * @param Closure $value
     * * Closure is the class used to represent anonymous functions
     * @return void
     */
    public function set(string $name, Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function get(string $className): object
    {
        if(array_key_exists($className, $this->registry)) {
            return $this->registry[$className]();
        }

        // Use reflector to get params of Controller constructor, that we need to provide while instanciates the Controller.
        // Because we don't know how many params and what exactly we have to provide here.
        $reflector = new ReflectionClass($className);
        $constructor = $reflector->getConstructor();
        $dependencies = [];

        if($constructor === null) {
            return new $className;
        }

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if($type === null) {
                throw new InvalidArgumentException("Constructor parameter '{$param->getName()}' in the $className class has no type declaration");
            }

            if(!($type instanceof ReflectionNamedType)) {
                throw new InvalidArgumentException("Constructor parameter '{$param->getName()}' in the $className class is an invalid type: '$type' - only single named types supported");
            }

            if($type->isBuiltin()) {
                throw new InvalidArgumentException("Unable to resolve constructor parameter '{$param->getName()}' of type '$type' in the $className class");
            }

            $dependencies[] = $this->get((string) $type);
        }


        // Auto wiring
        // Creating any dependencies automatically based on the type declarations in the controller
        return new $className(...$dependencies); // unpack array of dependencies instead of give specific params
    }
}