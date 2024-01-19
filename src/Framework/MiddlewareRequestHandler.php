<?php

declare(strict_types=1);

namespace Framework;

class MiddlewareRequestHandler implements RequestHandlerInterface
{
    public function __construct(private array $middlewares,
                                private ControllerRequestHandler $controller_handler)
    {
    }

    /**
     * Run each Middleware component from the array in turn, each time removing one from the top of array
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $middleware = array_shift($this->middlewares);

        // Once no middleware remaining, execute controller action.
        if ($middleware === null) {
            return $this->controller_handler->handle($request);
        }

        // Passed thiis object which contains the array of remaining middlewares
        return $middleware->process($request, $this);
    }
}