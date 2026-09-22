<?php

namespace App\Models\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformDomain extends Model
{
    protected $table = 'platform_domains';

    protected $guarded = [];

    public function tenant()
    {
        return $this->belongsTo(PlatformTenant::class, 'tenant_id');
    }
}
