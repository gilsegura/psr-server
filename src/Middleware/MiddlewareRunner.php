<?php

declare(strict_types=1);

namespace Psr\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class MiddlewareRunner
{
    /** @var MiddlewareInterface[] */
    private array $middlewares;

    public function __construct(
        MiddlewareInterface ...$middlewares,
    ) {
        $this->middlewares = $middlewares;
    }

    public function __invoke(ServerRequestInterface $serverRequest, RequestHandlerInterface $handler): ResponseInterface
    {
        $processor = array_reduce(
            array_reverse($this->middlewares),
            static fn (\Closure $stack, MiddlewareInterface $middleware): \Closure => static fn (ServerRequestInterface $request): ResponseInterface => $middleware->process($request, new StackMiddleware($stack)),
            static fn (ServerRequestInterface $request): ResponseInterface => $handler->handle($request),
        );

        return call_user_func($processor, $serverRequest);
    }
}
