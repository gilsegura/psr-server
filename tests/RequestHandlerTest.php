<?php

declare(strict_types=1);

namespace Psr\Server\Tests;

use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Server\Middleware\MiddlewareRunner;
use Psr\Server\RequestHandler;

final class RequestHandlerTest extends TestCase
{
    public function test_must_handle_request(): void
    {
        $response = new Response(200, ['Content-Type' => 'application/json']);
        $handler = RequestHandler::callable(
            new MiddlewareRunner(new ResponseMiddleware()),
            static fn (ServerRequestInterface $request): ResponseInterface => $response
        );

        $request = new ServerRequest('GET', 'https://www.example.com/users/1', ['Accept' => 'application/json']);
        $response = $handler->__invoke($request);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame(ResponseMiddleware::class, $response->getHeaderLine('X-Handled'));
    }
}

final readonly class ResponseMiddleware implements MiddlewareInterface
{
    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response->withHeader('X-Handled', __CLASS__);
    }
}
