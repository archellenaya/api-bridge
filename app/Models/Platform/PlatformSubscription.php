<?php

namespace App\Models\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformSubscription extends Model
{
    protected $table = 'platform_subscriptions';

    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(PlatformTenant::class, 'tenant_id');
    }
}
