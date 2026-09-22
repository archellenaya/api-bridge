<?php

namespace App\Services\Connectors;

use App\Services\Connectors\Contracts\ConnectorInterface;
use InvalidArgumentException;

class ConnectorFactory
{
    protected array $connectors = [];

    public function register(string $type, string $class): void
    {
        $this->connectors[$type] = $class;
    }

    public function make(string $type): ConnectorInterface
    {
        if (! isset($this->connectors[$type])) {
            throw new InvalidArgumentException("Connector type [{$type}] is not registered.");
        }

        $connector = app($this->connectors[$type]);

        if (! $connector instanceof ConnectorInterface) {
            throw new InvalidArgumentException("Connector [{$this->connectors[$type]}] must implement ConnectorInterface.");
        }

        return $connector;
    }
}
