<?php

namespace App\Services\Connectors;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RestApiConnector extends BaseConnector
{
    public function testConnection(array $config): bool
    {
        $config = SourceConfigValidator::validate($config);

        try {
            $response = Http::baseUrl($config['base_url'])
                ->withHeaders($config['headers'])
                ->timeout($config['timeout'])
                ->get('/');

            return $response->successful() || $response->status() === 404 || $response->status() === 401;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function execute(string $method, string $url, array $options = []): array
    {
        $options = $this->requestOptions($options);

        try {
            $response = Http::withHeaders($options['headers'])
                ->withOptions($options['http_options'])
                ->timeout($options['timeout'])
                ->send($method, $url, $options['payload']);

            return $this->normalizeResponse($response);
        } catch (\Throwable $exception) {
            throw new RuntimeException($exception->getMessage(), 0, $exception);
        }
    }
}
