<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

enum Status: int
{
    case CONTINUE = 100;
    case SWITCHING_PROTOCOLS = 101;
    case OK = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case CONFLICT = 409;
    case UNPROCESSABLE_CONTENT = 422;
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case SERVICE_UNAVAILABLE = 503;

    public function reasonPhrase(): string
    {
        return match ($this) {
            self::CONTINUE => 'Continue',
            self::SWITCHING_PROTOCOLS => 'Switching Protocols',
            self::OK => 'OK',
            self::CREATED => 'Created',
            self::NO_CONTENT => 'No Content',
            self::BAD_REQUEST => 'Bad Request',
            self::UNAUTHORIZED => 'Unauthorized',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::CONFLICT => 'Conflict',
            self::UNPROCESSABLE_CONTENT => 'Unprocessable Content',
            self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
            self::NOT_IMPLEMENTED => 'Not Implemented',
            self::SERVICE_UNAVAILABLE => 'Service Unavailable',
        };
    }
}
