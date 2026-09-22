<?php

namespace App\Providers;

use App\Services\Connectors\ConnectorFactory;
use App\Services\Connectors\RestApiConnector;
use Illuminate\Support\ServiceProvider;

class PhaseOneServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ConnectorFactory::class, function () {
            $factory = new ConnectorFactory();
            $factory->register('rest', RestApiConnector::class);

            return $factory;
        });

        $this->app->bind(RestApiConnector::class, function () {
            return new RestApiConnector();
        });
    }

    public function boot(): void
    {
        // Phase 1 bootstrap hook.
    }
}
