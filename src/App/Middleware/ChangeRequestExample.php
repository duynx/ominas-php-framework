<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;
use Framework\MiddlewareInterface;

class ChangeRequestExample implements MiddlewareInterface
{
    /**
     * Change request before its passed down the chain
     * @param Request $request
     * @param RequestHandlerInterface $next
     * @return Response
     */
    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        $request->post = array_map("trim", $request->post);
        $response = $next->handle($request);

        return $response;
    }
}