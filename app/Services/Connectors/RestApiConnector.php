<?php

namespace App\Services\Connectors;

use App\Services\Connectors\Contracts\ConnectorInterface;
use Illuminate\Support\Facades\Http;

class RestApiConnector implements ConnectorInterface
{
    public function testConnection(array $config): bool
    {
        $response = Http::baseUrl($config['base_url'] ?? '')->withHeaders($config['headers'] ?? [])->get('/');

        return $response->successful() || $response->status() === 404 || $response->status() === 401;
    }

    public function execute(string $method, string $url, array $options = []): array
    {
        $response = Http::withHeaders($options['headers'] ?? [])
            ->withOptions($options['http_options'] ?? [])
            ->send($method, $url, $options['payload'] ?? []);

        return [
            'status' => $response->status(),
            'body' => $response->json(),
            'headers' => $response->headers(),
        ];
    }
}
