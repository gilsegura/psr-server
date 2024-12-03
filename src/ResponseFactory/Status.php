<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

use ProxyAssert\Assertion;

final readonly class Status
{
    public const int CONTINUE = 100;

    public const int SWITCHING_PROTOCOLS = 101;

    public const int PROCESSING = 102;

    public const int EARLY_HINTS = 103;

    public const int OK = 200;

    public const int CREATED = 201;

    public const int ACCEPTED = 202;

    public const int NON_AUTHORITATIVE_INFORMATION = 203;

    public const int NO_CONTENT = 204;

    public const int RESET_CONTENT = 205;

    public const int PARTIAL_CONTENT = 206;

    public const int MULTI_STATUS = 207;

    public const int ALREADY_REPORTED = 208;

    public const int IM_USED = 226;

    public const int MULTIPLE_CHOICES = 300;

    public const int MOVED_PERMANENTLY = 301;

    public const int FOUND = 302;

    public const int SEE_OTHER = 303;

    public const int NOT_MODIFIED = 304;

    public const int USE_PROXY = 305;

    public const int TEMPORARY_REDIRECT = 307;

    public const int PERMANENT_REDIRECT = 308;

    public const int BAD_REQUEST = 400;

    public const int UNAUTHORIZED = 401;

    public const int PAYMENT_REQUIRED = 402;

    public const int FORBIDDEN = 403;

    public const int NOT_FOUND = 404;

    public const int METHOD_NOT_ALLOWED = 405;

    public const int NOT_ACCEPTABLE = 406;

    public const int PROXY_AUTHENTICATION_REQUIRED = 407;

    public const int REQUEST_TIMEOUT = 408;

    public const int CONFLICT = 409;

    public const int GONE = 410;

    public const int LENGTH_REQUIRED = 411;

    public const int PRECONDITION_FAILED = 412;

    public const int CONTENT_TOO_LARGE = 413;

    public const int URI_TOO_LARGE = 414;

    public const int UNSUPPORTED_MEDIA_TYPE = 415;

    public const int RANGE_NOT_SATISFIABLE = 416;

    public const int EXPECTATION_FAILED = 417;

    public const int MISDIRECT_REQUEST = 421;

    public const int UNPROCESSABLE_CONTENT = 422;

    public const int LOCKED = 423;

    public const int FAILED_DEPENDENCY = 424;

    public const int TOO_EARLY = 425;

    public const int UPGRADE_REQUIRED = 426;

    public const int PRECONDITION_REQUIRED = 428;

    public const int TOO_MANY_REQUESTS = 429;

    public const int REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    public const int UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    public const int INTERNAL_SERVER_ERROR = 500;

    public const int NOT_IMPLEMENTED_METHOD = 501;

    public const int BAD_GATEWAY = 502;

    public const int SERVICE_UNAVAILABLE = 503;

    public const int GATEWAY_TIMEOUT = 504;

    public const int HTTP_VERSION_NOT_SUPPORTED = 505;

    public const int VARIANT_ALSO_NEGOTIATES = 506;

    public const int INSUFFICIENT_STORAGE = 507;

    public const int LOOP_DETECTED = 508;

    public const int NETWORK_AUTHENTICATION_REQUIRED = 511;

    public const array REASON_PHRASES = [
        self::CONTINUE => 'Continue',
        self::SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::PROCESSING => 'Processing',
        self::EARLY_HINTS => 'Early Hints',
        // 104-199 unassigned
        self::OK => 'OK',
        self::CREATED => 'Created',
        self::ACCEPTED => 'Accepted',
        self::NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
        self::NO_CONTENT => 'No Content',
        self::RESET_CONTENT => 'Reset Content',
        self::PARTIAL_CONTENT => 'Partial Content',
        self::MULTI_STATUS => 'Multi-status',
        self::ALREADY_REPORTED => 'Already Reported',
        // 209-225 unassigned
        self::IM_USED => 'IM Used',
        // 227-999 unassigned
        self::MULTIPLE_CHOICES => 'Multiple Choices',
        self::MOVED_PERMANENTLY => 'Moved Permanently',
        self::FOUND => 'Found',
        self::SEE_OTHER => 'See Other',
        self::NOT_MODIFIED => 'Not Modified',
        self::USE_PROXY => 'Use Proxy',
        // 306 unused
        self::TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::PERMANENT_REDIRECT => 'Permanent Redirect',
        // 309-399 unassigned
        self::BAD_REQUEST => 'Bad Request',
        self::UNAUTHORIZED => 'Unauthorized',
        self::PAYMENT_REQUIRED => 'Payment Required',
        self::FORBIDDEN => 'Forbidden',
        self::NOT_FOUND => 'Not Found',
        self::METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::NOT_ACCEPTABLE => 'Not Acceptable',
        self::PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
        self::REQUEST_TIMEOUT => 'Request Time-out',
        self::CONFLICT => 'Conflict',
        self::GONE => 'Gone',
        self::LENGTH_REQUIRED => 'Length Required',
        self::PRECONDITION_FAILED => 'Precondition Failed',
        self::CONTENT_TOO_LARGE => 'Content Too Large',
        self::URI_TOO_LARGE => 'URI Too Large',
        self::UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        self::RANGE_NOT_SATISFIABLE => 'Range Not Satisfiable',
        self::EXPECTATION_FAILED => 'Expectation Failed',
        // 418 unused
        // 419-420 unassigned
        self::MISDIRECT_REQUEST => 'Misdirected Request',
        self::UNPROCESSABLE_CONTENT => 'Unprocessable Content',
        self::LOCKED => 'Locked',
        self::FAILED_DEPENDENCY => 'Failed Dependency',
        self::TOO_EARLY => 'Too Early',
        self::UPGRADE_REQUIRED => 'Upgrade Required',
        // 427 unassigned
        self::PRECONDITION_REQUIRED => 'Precondition Required',
        self::TOO_MANY_REQUESTS => 'Too Many Requests',
        // 430 unassigned
        self::REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',
        // 432-450 unassigned
        self::UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons',
        // 452-499 unassigned
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::NOT_IMPLEMENTED_METHOD => 'Not Implemented method.',
        self::BAD_GATEWAY => 'Bad Gateway',
        self::SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::GATEWAY_TIMEOUT => 'Gateway Time-out',
        self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        self::VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',
        self::INSUFFICIENT_STORAGE => 'Insufficient Storage',
        self::LOOP_DETECTED => 'Loop Detected',
        // 509 unassigned
        // 510 obsoleted
        self::NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required',
        // 512-599 unassigned
    ];

    public int $code;

    public string $reasonPhrase;

    public function __construct(
        int $code,
        string $reasonPhrase = '',
    ) {
        Assertion::between($code, 100, 599);

        $this->code = $code;
        $this->reasonPhrase = self::REASON_PHRASES[$code] ?? $reasonPhrase;
    }
}
