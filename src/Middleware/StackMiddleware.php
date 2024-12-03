<?php

declare(strict_types=1);

namespace Psr\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class StackMiddleware implements RequestHandlerInterface
{
    public function __construct(
        private \Closure $stack,
    ) {
    }

    #[\Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func($this->stack, $request);
    }
}
