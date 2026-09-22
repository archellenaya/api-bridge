<?php

namespace App\Models\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $table = 'platform_settings';

    protected $guarded = [];

    protected $casts = [
        'value' => 'json',
    ];

    public static function set(int $tenantId, string $key, mixed $value): self
    {
        $setting = static::query()->firstOrNew([
            'tenant_id' => $tenantId,
            'key' => $key,
        ]);

        $setting->value = $value;
        $setting->save();

        return $setting;
    }

    public static function get(int $tenantId, string $key, mixed $default = null): mixed
    {
        $setting = static::query()->where('tenant_id', $tenantId)->where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }
}
