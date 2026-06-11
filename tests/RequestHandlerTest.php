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
    public function test_must_handle_request_with_terminal_handler(): void
    {
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
        );

        $handler = new RequestHandler(
            static fn (ServerRequestInterface $request): Response => $response,
        );

        $request = new ServerRequest(
            'GET',
            'https://www.example.com/users/1',
        );

        self::assertSame($response, $handler->handle($request));
    }

    public function test_must_run_middleware_pipeline_in_order(): void
    {
        $runner = new MiddlewareRunner(
            new AppendHeaderMiddleware('X-First', 'first'),
            new AppendHeaderMiddleware('X-Second', 'second'),
        );

        $terminal = new RequestHandler(
            static fn (ServerRequestInterface $request): Response => new Response(200),
        );

        $request = new ServerRequest(
            'GET',
            'https://www.example.com/users/1',
        );

        $response = $runner($request, $terminal);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('first', $response->getHeaderLine('X-First'));
        self::assertSame('second', $response->getHeaderLine('X-Second'));
    }

    public function test_must_handle_request_without_middlewares(): void
    {
        $runner = new MiddlewareRunner();

        $expected = new Response(204);

        $terminal = new RequestHandler(
            static fn (ServerRequestInterface $request): Response => $expected,
        );

        $request = new ServerRequest(
            'GET',
            'https://www.example.com/users/1',
        );

        self::assertSame(
            $expected,
            $runner($request, $terminal),
        );
    }
}

final readonly class AppendHeaderMiddleware implements MiddlewareInterface
{
    public function __construct(
        private string $name,
        private string $value,
    ) {
    }

    #[\Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $response = $handler->handle($request);

        return $response->withHeader($this->name, $this->value);
    }
}
