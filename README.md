# PSR SERVER COMPONENT

[![tests](https://github.com/gilsegura/psr-server/actions/workflows/tests.yaml/badge.svg)](https://github.com/gilsegura/psr-server/actions/workflows/tests.yaml)
[![codecov](https://codecov.io/github/gilsegura/psr-server/graph/badge.svg)](https://codecov.io/github/gilsegura/psr-server)
[![static analysis](https://github.com/gilsegura/psr-server/actions/workflows/static-analysis.yaml/badge.svg)](https://github.com/gilsegura/psr-server/actions/workflows/static-analysis.yaml)
[![coding standards](https://github.com/gilsegura/psr-server/actions/workflows/coding-standards.yaml/badge.svg)](https://github.com/gilsegura/psr-server/actions/workflows/coding-standards.yaml)

A lightweight PSR HTTP server component for PHP applications.

The component provides infrastructure for building PSR-15 request handlers and
middleware pipelines, plus a typed response factory for serializable payloads.

## Features

* PHP 8.4+
* PSR-7, PSR-15 and PSR-17 compliant
* Strong static typing
* PHPStan-friendly templates
* Immutable design
* Framework agnostic
* No runtime reflection
* No exception handling: errors surface to the caller as `\Throwable`
* Ideal for DDD, CQRS and Event Sourcing architectures

## Installation

```bash
composer require gilsegura/psr-server
```

## Usage

### Terminal request handler

`RequestHandler` is a PSR-15 entry point that wraps a closure as the final
handler of the pipeline.

```php
<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Server\RequestHandler;

$handler = new RequestHandler(
    static fn (ServerRequestInterface $request): ResponseInterface => $response,
);

$response = $handler->handle($request);
```

### Middleware pipeline

`MiddlewareRunner` composes a list of PSR-15 middlewares around a terminal
handler. Middlewares run in the order they are declared.

```php
use Psr\Server\Middleware\MiddlewareRunner;
use Psr\Server\RequestHandler;

$runner = new MiddlewareRunner(
    new AuthenticationMiddleware(),
    new LoggingMiddleware(),
);

$terminal = new RequestHandler(
    static fn (ServerRequestInterface $request): ResponseInterface => $response,
);

$response = $runner($request, $terminal);
```

The pipeline is built by wrapping each middleware around the next, so the first
middleware declared is the outermost one.

### Response factory

`ResponseFactory` builds a PSR-7 response from a `Status` and an optional
serializable body. The body is encoded as JSON using its `serialize()`
representation.

```php
use Psr\Server\ResponseFactory\ResponseFactory;
use Psr\Server\ResponseFactory\Status;

$factory = new ResponseFactory($psr17ResponseFactory, $psr17StreamFactory);

$response = $factory(Status::OK, $body);
```

The factory does not add headers. Set them on the returned response using the
standard PSR-7 API, so the caller stays in control of what each response carries:

```php
$response = $factory(Status::OK, $body)
    ->withHeader('Content-Type', 'application/json');
```

A response without a body:

```php
$response = $factory(Status::NO_CONTENT);
```

### Status

`Status` is a backed enum of HTTP status codes. Each case exposes its standard
reason phrase.

```php
use Psr\Server\ResponseFactory\Status;

Status::OK->value;            // 200
Status::OK->reasonPhrase();   // "OK"
Status::NOT_FOUND->value;     // 404
```

Using an enum makes invalid status codes unrepresentable at the type level.

## Validation

The component assumes the payload is valid.

It does not define or handle any exceptions. When a body cannot be serialized or
encoded, the underlying `\Throwable` surfaces to the caller unchanged. Both the
response factory and any serializable body are documented as `@throws
\Throwable`, leaving error handling to each application.

## Static analysis

The component uses PHPStan templates to preserve concrete types through the
middleware pipeline and the response factory body. The factory's `__invoke`
infers the body's attribute shape per call, so a serializable body keeps its
declared shape without casts:

```php
$response = $factory(Status::OK, $body);
```

The body implements `Serializer\SerializableInterface<TAttributes>`, where
`TAttributes` is the concrete shape of the serialized array declared in the
body's `@implements` tag.

## License

MIT. See [LICENSE](LICENSE).
