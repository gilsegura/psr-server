<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

final readonly class Header
{
    public function __construct(
        public string $name,
        public string $value,
    ) {
        if ('' === $name) {
            throw new \InvalidArgumentException('Header name cannot be empty');
        }
    }

    public static function kv(string $name, string $value): self
    {
        return new self($name, $value);
    }
}
