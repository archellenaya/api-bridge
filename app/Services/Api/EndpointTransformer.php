<?php

namespace App\Services\Api;

use Illuminate\Support\Arr;

class EndpointTransformer
{
    public function apply(array $payload, array $transform): mixed
    {
        if (empty($transform['path'])) {
            return $payload;
        }

        return Arr::get($payload, $transform['path']);
    }
}
