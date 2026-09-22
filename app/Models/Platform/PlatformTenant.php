<?php

namespace App\Models\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformTenant extends Model
{
    protected $table = 'platform_tenants';

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function domains()
    {
        return $this->hasMany(PlatformDomain::class, 'tenant_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(PlatformSubscription::class, 'tenant_id');
    }

    public function settings()
    {
        return $this->hasMany(PlatformSetting::class, 'tenant_id');
    }
}
