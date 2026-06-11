<?php

declare(strict_types=1);

namespace Psr\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @template TResponse of ResponseInterface
 */
final readonly class RequestHandler implements RequestHandlerInterface
{
    /**
     * @param \Closure(ServerRequestInterface): TResponse $handler
     */
    public function __construct(
        private \Closure $handler,
    ) {
    }

    /**
     * @return TResponse
     */
    #[\Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->handler)($request);
    }
}
