# PSR SERVER
[![tests](https://github.com/gilsegura/psr-server/actions/workflows/tests.yaml/badge.svg)](https://github.com/gilsegura/psr-server/actions/workflows/tests.yaml)
[![codecov](https://codecov.io/github/gilsegura/psr-server/graph/badge.svg)](https://codecov.io/github/gilsegura/psr-server)
[![static analysis](https://github.com/gilsegura/psr-server/actions/workflows/static-analysis.yaml/badge.svg)](https://github.com/gilsegura/psr-server/actions/workflows/static-analysis.yaml)
[![coding standards](https://github.com/gilsegura/psr-server/actions/workflows/coding-standards.yaml/badge.svg)](https://github.com/gilsegura/psr-server/actions/workflows/coding-standards.yaml)

Minimal, framework-agnostic PSR-15 server primitives: a middleware runner, a
request handler and a response factory. It gives you the small pieces needed to
run a request through a middleware pipeline and build a response, without pulling
in a full framework.

## Installation

```bash
composer require gilsegura/psr-server
```

## Middleware pipeline

- **`MiddlewareRunner`** — takes a variadic list of PSR-15 middlewares and runs a
  request through them in order, delegating to a terminal `RequestHandlerInterface`
  at the end. It is the engine behind a request pipeline.
- **`StackMiddleware`** — adapts the run to the PSR-15 stack model, advancing to
  the next middleware in the chain.
- **`RequestHandler`** — a `RequestHandlerInterface` that wraps the runner and a
  terminal handler, so the whole pipeline is itself a single PSR-15 handler.

## Responses

- **`ResponseFactory`** — an invokable that builds a PSR-7 response from a status
  and body.
- **`Status`** — an `int`-backed enum of HTTP status codes (`OK`, `CREATED`,
  `NO_CONTENT`, `BAD_REQUEST`, `UNAUTHORIZED`, …), so status codes are referenced
  by name instead of magic numbers.

## License
MIT. See [LICENSE](LICENSE).