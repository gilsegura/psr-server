<?php

declare(strict_types=1);

namespace Psr\Server\ResponseFactory;

final class ResponseFactoryException extends \Exception
{
    public static function throwable(\Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}
