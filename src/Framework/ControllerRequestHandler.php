<?php
declare(strict_types=1);

namespace Framework;

class ControllerRequestHandler implements RequestHandlerInterface
{
    public function __construct(private Controller $controller,
                                private string $action,
                                private array $args)
    {
    }

    public function handle(Request $request): Response
    {
        // Avoids any ambiguity about where the request object is being sent to the controller.
        $this->controller->setRequest($request);

        return ($this->controller)->{$this->action}(...$this->args);
    }
}