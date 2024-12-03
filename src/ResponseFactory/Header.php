<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

use ProxyAssert\Assertion;

final readonly class Header
{
    public string $name;

    private function __construct(
        string $name,
        public string $value,
    ) {
        Assertion::notEmpty($name);

        $this->name = $name;
    }

    public static function kv(
        string $name,
        string $value,
    ): self {
        return new self(
            $name,
            $value
        );
    }
}
