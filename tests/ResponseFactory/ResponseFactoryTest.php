<?php

declare(strict_types=1);

namespace Psr\Server\Tests\ResponseFactory;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Server\ResponseFactory\Header;
use Psr\Server\ResponseFactory\ResponseFactory;
use Psr\Server\ResponseFactory\Status;
use Serializer\SerializableInterface;

final class ResponseFactoryTest extends TestCase
{
    public function test_must_create_response_with_status_and_headers(): void
    {
        $factory = $this->factory();

        $contentType = Header::kv('Content-Type', 'application/json');
        $body = new Body();

        $response = $factory->__invoke(Status::OK, [$contentType], $body);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame(Status::OK->value, $response->getStatusCode());
        self::assertSame(Status::OK->reasonPhrase(), $response->getReasonPhrase());
        self::assertSame($contentType->value, $response->getHeaderLine($contentType->name));
        self::assertSame(json_encode($body->serialize()), $response->getBody()->__toString());
    }

    public function test_must_create_response_without_body(): void
    {
        $factory = $this->factory();

        $response = $factory->__invoke(Status::NO_CONTENT);

        self::assertSame(Status::NO_CONTENT->value, $response->getStatusCode());
        self::assertSame('', $response->getBody()->__toString());
    }

    public function test_must_let_body_errors_surface(): void
    {
        $factory = $this->factory();

        self::expectException(\Exception::class);

        $factory->__invoke(Status::OK, [], new ThrowableBody());
    }

    /**
     * @return ResponseFactory<SerializableInterface|null>
     */
    private function factory(): ResponseFactory
    {
        $psr17 = new Psr17Factory();

        return new ResponseFactory($psr17, $psr17);
    }
}

final readonly class Body implements SerializableInterface
{
    #[\Override]
    public static function deserialize(array $data): static
    {
        return new self();
    }

    #[\Override]
    public function serialize(): array
    {
        return ['id' => '1'];
    }
}

final readonly class ThrowableBody implements SerializableInterface
{
    #[\Override]
    public static function deserialize(array $data): static
    {
        throw new \Exception('cannot deserialize');
    }

    #[\Override]
    public function serialize(): array
    {
        throw new \Exception('cannot serialize');
    }
}
