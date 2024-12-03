<?php

declare(strict_types=1);

namespace Psr\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Server\Middleware\MiddlewareRunner;

final readonly class RequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private MiddlewareRunner $runner,
        private \Closure $handler,
    ) {
    }

    public static function callable(
        MiddlewareRunner $runner,
        callable $callable,
    ): self {
        return new self($runner, \Closure::fromCallable($callable));
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->runner->__invoke($request, $this);
    }

    #[\Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func($this->handler, $request);
    }
}
