<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $table = 'tenant_settings';

    protected $guarded = [];

    protected $casts = [
        'value' => 'json',
    ];

    public static function set(string $key, mixed $value): self
    {
        $setting = static::query()->firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();

        return $setting;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::query()->where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }
}
