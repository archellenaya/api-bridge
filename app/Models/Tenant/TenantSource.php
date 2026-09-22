<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantSource extends Model
{
    protected $table = 'tenant_sources';

    protected $guarded = [];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function endpoints()
    {
        return $this->hasMany(TenantEndpoint::class, 'source_id');
    }
}
