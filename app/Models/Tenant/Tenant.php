<?php

namespace App\Models\Tenant;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    protected $guarded = [];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'slug',
            'status',
            'owner_email',
            'database_name',
            'created_at',
            'updated_at',
        ];
    }
}
