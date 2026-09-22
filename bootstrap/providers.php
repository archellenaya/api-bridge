<?php

use App\Providers\AppServiceProvider;
use App\Providers\PhaseOneServiceProvider;
use App\Providers\TenancyServiceProvider;

return [
    AppServiceProvider::class,
    PhaseOneServiceProvider::class,
    TenancyServiceProvider::class,
];
