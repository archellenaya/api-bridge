<?php

namespace Tests\Unit;

use App\Services\Connectors\ConnectorFactory;
use App\Services\Connectors\ConnectorErrorNormalizer;
use App\Services\Connectors\SourceConfigValidator;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PhaseTwoSourceConnectorTest extends TestCase
{
    public function test_factory_builds_registered_connector(): void
    {
        $factory = new ConnectorFactory();
        $factory->register('rest', \App\Services\Connectors\RestApiConnector::class);

        $connector = $factory->make('rest');

        $this->assertSame(\App\Services\Connectors\RestApiConnector::class, $connector::class);
    }

    public function test_source_configuration_validation_accepts_valid_rest_config(): void
    {
        $config = [
            'type' => 'rest',
            'base_url' => 'https://api.example.com',
            'headers' => ['Accept' => 'application/json'],
            'timeout' => 10,
        ];

        $this->assertSame([
            'type' => 'rest',
            'base_url' => 'https://api.example.com',
            'headers' => ['Accept' => 'application/json'],
            'timeout' => 10,
        ], SourceConfigValidator::validate($config));
    }

    public function test_rest_connector_executes_and_normalizes_errors(): void
    {
        Http::fake([
            'https://api.example.com/*' => Http::response(['ok' => true], 200),
        ]);

        $connector = app(ConnectorFactory::class)->make('rest');
        $result = $connector->execute('GET', 'https://api.example.com/v1/test', [
            'headers' => ['Accept' => 'application/json'],
        ]);

        $this->assertSame(200, $result['status']);
        $this->assertSame(['ok' => true], $result['body']);

        $error = ConnectorErrorNormalizer::normalize(new \RuntimeException('Request failed'), [
            'source' => 'demo',
        ]);

        $this->assertSame('Request failed', $error['message']);
        $this->assertSame('RuntimeException', $error['type']);
        $this->assertSame('demo', $error['context']['source']);
    }
}
