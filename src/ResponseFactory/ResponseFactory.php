<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Serializer\SerializableInterface;

final readonly class ResponseFactory
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {
    }

    /**
     * @template TAttributes of array
     *
     * @param SerializableInterface<TAttributes>|null $body
     *
     * @throws \Throwable
     */
    public function __invoke(
        Status $status,
        ?SerializableInterface $body = null,
    ): ResponseInterface {
        $response = $this->responseFactory
            ->createResponse($status->value, $status->reasonPhrase())
            ->withProtocolVersion('1.1');

        if ($body instanceof SerializableInterface) {
            $json = json_encode(
                $body->serialize(),
                JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION
            );

            $response = $response->withBody(
                $this->streamFactory->createStream($json)
            );
        }

        return $response;
    }
}
