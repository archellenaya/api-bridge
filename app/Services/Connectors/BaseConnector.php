<?php

namespace App\Services\Connectors;

use App\Services\Connectors\Contracts\ConnectorInterface;

abstract class BaseConnector implements ConnectorInterface
{
    protected function requestOptions(array $options = []): array
    {
        return [
            'headers' => $options['headers'] ?? [],
            'payload' => $options['payload'] ?? [],
            'http_options' => $options['http_options'] ?? [],
            'timeout' => $options['timeout'] ?? 30,
        ];
    }

    protected function normalizeResponse(mixed $response): array
    {
        return [
            'status' => $response->status(),
            'body' => $response->json() ?? $response->body(),
            'headers' => $response->headers(),
        ];
    }
}
