<?php

declare(strict_types=1);

namespace Psr\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Server\RequestHandler;

/**
 * @template TRequest of ServerRequestInterface
 */
final readonly class MiddlewareRunner
{
    /**
     * @var MiddlewareInterface[]
     */
    private array $middlewares;

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * @template TResponse of ResponseInterface
     *
     * @param TRequest                  $request
     * @param RequestHandler<TResponse> $handler
     *
     * @return TResponse
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            static function (callable $next, MiddlewareInterface $middleware): callable {
                return static function (ServerRequestInterface $request) use ($middleware, $next): ResponseInterface {
                    return $middleware->process($request, new StackMiddleware($next));
                };
            },
            static fn (ServerRequestInterface $request): ResponseInterface => $handler->handle($request)
        );

        /** @var TResponse $response */
        $response = $pipeline($request);

        return $response;
    }
}
