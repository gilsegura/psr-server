<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

use Http\Discovery\Psr17FactoryDiscovery;
use ProxyAssert\Assertion;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Serializer\SerializableInterface;

final readonly class ResponseFactory
{
    private ResponseFactoryInterface $responseFactory;

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        ?ResponseFactoryInterface $responseFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        $this->responseFactory = $responseFactory ?? Psr17FactoryDiscovery::findResponseFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    /**
     * @param Header[] $headers
     *
     * @throws ResponseFactoryException
     */
    public function __invoke(
        int $code,
        array $headers = [],
        ?SerializableInterface $body = null,
    ): ResponseInterface {
        try {
            Assertion::allIsInstanceOf($headers, Header::class);

            $status = new Status($code);

            $response = $this->responseFactory
                ->createResponse($status->code, $status->reasonPhrase)
                ->withProtocolVersion('1.1');

            if ($body instanceof SerializableInterface) {
                $response = $response->withBody(
                    $this->streamFactory->createStream(
                        (string) json_encode($body->serialize(), JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION)
                    )
                );
            }

            foreach ($headers as $header) {
                $response = $response->withHeader($header->name, $header->value);
            }

            return $response;
        } catch (\Throwable $e) {
            throw ResponseFactoryException::throwable($e);
        }
    }
}
