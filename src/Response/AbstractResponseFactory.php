<?php

declare(strict_types=1);

namespace Psr\Server\Response;

use Assert\Assertion;
use Http\Discovery\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

abstract readonly class AbstractResponseFactory
{
    /**
     * @var array<int, string>
     */
    protected const array REASON_PHRASES = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        // 104-199 unassigned
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        // 209-225 unassigned
        226 => 'IM Used',
        // 227-999 unassigned
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 unused
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        // 309-399 unassigned
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Content Too Large',
        414 => 'URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        // 418 unused
        // 419-420 unassigned
        421 => 'Misdirected Request',
        422 => 'Unprocessable Content',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        // 427 unassigned
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        // 430 unassigned
        431 => 'Request Header Fields Too Large',
        // 432-450 unassigned
        451 => 'Unavailable For Legal Reasons',
        // 452-499 unassigned
        500 => 'Internal Server Error',
        501 => 'Not implemented method.',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        // 509 unassigned
        // 510 obsoleted
        511 => 'Network Authentication Required',
        // 512-599 unassigned
    ];

    private int $code;

    private string $protocol;

    private string $reasonPhrase;

    protected function __construct(
        int $code,
        /** @var array<string, string|string[]> */
        private array $headers = [],
        private string $body = '',
        string $protocol = '1.1',
        string $reasonPhrase = '',
    ) {
        Assertion::between($code, 100, 599);
        Assertion::scalar($protocol);

        if (isset(self::REASON_PHRASES[$code])) {
            $reasonPhrase = self::REASON_PHRASES[$code];
        }

        $this->code = $code;
        $this->protocol = $protocol;
        $this->reasonPhrase = $reasonPhrase;
    }

    final public function __invoke(): ResponseInterface
    {
        $factory = new Psr17Factory();

        $response = $factory
            ->createResponse($this->code, $this->reasonPhrase)
            ->withProtocolVersion($this->protocol)
            ->withBody(
                $factory->createStream($this->body)
            );

        foreach ($this->headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        return $response;
    }
}
