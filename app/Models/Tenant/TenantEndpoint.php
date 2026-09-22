<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantEndpoint extends Model
{
    protected $table = 'tenant_endpoints';

    protected $guarded = [];

    protected $casts = [
        'transform' => 'array',
        'is_enabled' => 'boolean',
    ];

    public function source()
    {
        return $this->belongsTo(TenantSource::class, 'source_id');
    }
}
