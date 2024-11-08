<?php

declare(strict_types=1);

namespace Psr\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class Server implements ServerInterface
{
    public function __construct(
        private RequestHandlerInterface $handler,
    ) {
    }

    #[\Override]
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->handler->__invoke($request);
    }
}
