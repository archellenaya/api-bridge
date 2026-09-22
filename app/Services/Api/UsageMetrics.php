<?php

namespace App\Services\Api;

class UsageMetrics
{
    public static function capture(string $metric, int $count = 1): array
    {
        return [
            'metric' => $metric,
            'count' => $count,
            'captured_at' => now()->toISOString(),
        ];
    }
}
