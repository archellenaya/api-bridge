<?php

namespace App\Services\Connectors;

use Throwable;

class ConnectorErrorNormalizer
{
    public static function normalize(Throwable $exception, array $context = []): array
    {
        return [
            'message' => $exception->getMessage(),
            'type' => class_basename($exception),
            'code' => $exception->getCode(),
            'context' => $context,
            'trace' => array_slice($exception->getTrace(), 0, 5),
        ];
    }
}
