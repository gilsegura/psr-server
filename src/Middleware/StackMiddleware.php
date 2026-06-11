<?php

declare(strict_types=1);

namespace Psr\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @template TRequest of ServerRequestInterface
 * @template TResponse of ResponseInterface
 */
final readonly class StackMiddleware implements RequestHandlerInterface
{
    /**
     * @param \Closure(ServerRequestInterface): ResponseInterface $next
     */
    public function __construct(
        private \Closure $next,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->next)($request);
    }
}
