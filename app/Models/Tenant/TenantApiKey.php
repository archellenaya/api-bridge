<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class TenantApiKey extends Model
{
    protected $table = 'tenant_api_keys';

    protected $guarded = [];

    protected $casts = [
        'last_used_at' => 'datetime',
    ];

    public static function hashValue(string $value): string
    {
        return Hash::make($value);
    }

    public function matches(string $value): bool
    {
        return Hash::check($value, $this->key_hash);
    }
}
