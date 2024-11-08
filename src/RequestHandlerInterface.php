<?php

declare(strict_types=1);

namespace Psr\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestHandlerInterface
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface;
}
