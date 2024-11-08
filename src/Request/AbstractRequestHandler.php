<?php

declare(strict_types=1);

namespace Psr\Server\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as PsrRequestHandlerInterface;
use Psr\Server\Middleware\MiddlewareRunner;
use Psr\Server\RequestHandlerInterface;

abstract readonly class AbstractRequestHandler implements RequestHandlerInterface, PsrRequestHandlerInterface
{
    protected function __construct(
        private MiddlewareRunner $middlewareRunner,
        private \Closure $handler,
    ) {
    }

    #[\Override]
    final public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middlewareRunner->__invoke($request, $this);
    }

    #[\Override]
    final public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->handler)($request);
    }
}
