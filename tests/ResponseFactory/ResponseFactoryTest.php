<?php

declare(strict_types=1);

namespace Psr\Server\Tests\ResponseFactory;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Server\ResponseFactory\Header;
use Psr\Server\ResponseFactory\ResponseFactory;
use Psr\Server\ResponseFactory\ResponseFactoryException;
use Psr\Server\ResponseFactory\Status;
use Serializer\SerializableInterface;

final class ResponseFactoryTest extends TestCase
{
    public function test_must_throw_factory_exception(): void
    {
        self::expectException(ResponseFactoryException::class);

        $factory = new ResponseFactory();

        $factory->__invoke(
            Status::OK,
            [Header::kv('Content-Type', 'application/json')],
            new ThrowableBody()
        );
    }

    public function test_must_create_response(): void
    {
        $factory = new ResponseFactory();

        $code = Status::OK;
        $contentType = Header::kv('Content-Type', 'application/json');
        $body = new Body();

        $response = $factory->__invoke($code, [$contentType], $body);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame($code, $response->getStatusCode());
        self::assertSame(Status::REASON_PHRASES[$code], $response->getReasonPhrase());
        self::assertSame($contentType->value, $response->getHeaderLine($contentType->name));
        self::assertSame(json_encode($body->serialize()), $response->getBody()->__toString());
    }
}

final class Body implements SerializableInterface
{
    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self();
    }

    #[\Override]
    public function serialize(): array
    {
        return [];
    }
}

final class ThrowableBody implements SerializableInterface
{
    #[\Override]
    public static function deserialize(array $data): self
    {
        throw new \Exception();
    }

    #[\Override]
    public function serialize(): array
    {
        throw new \Exception();
    }
}
