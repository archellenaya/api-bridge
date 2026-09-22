<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantRequestLog extends Model
{
    protected $table = 'tenant_request_logs';

    protected $guarded = [];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
        'occurred_at' => 'datetime',
    ];
}
