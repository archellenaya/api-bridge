<?php

namespace App\Services\Connectors\Contracts;

interface ConnectorInterface
{
    public function testConnection(array $config): bool;

    public function execute(string $method, string $url, array $options = []): array;
}
