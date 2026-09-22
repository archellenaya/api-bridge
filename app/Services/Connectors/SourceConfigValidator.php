<?php

namespace App\Services\Connectors;

use InvalidArgumentException;

class SourceConfigValidator
{
    public static function validate(array $config): array
    {
        if (empty($config['type'])) {
            throw new InvalidArgumentException('Source type is required.');
        }

        if ($config['type'] === 'rest') {
            if (empty($config['base_url'])) {
                throw new InvalidArgumentException('REST source requires a base_url.');
            }

            if (! isset($config['headers']) || ! is_array($config['headers'])) {
                $config['headers'] = [];
            }

            if (! isset($config['timeout']) || ! is_numeric($config['timeout'])) {
                $config['timeout'] = 30;
            }

            $config['timeout'] = (int) $config['timeout'];
        }

        return $config;
    }
}
