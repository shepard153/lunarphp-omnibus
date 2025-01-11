<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus;

use Illuminate\Support\ServiceProvider;

class OmnibusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app['events']->listen(
            'Lunar\\Models\\ProductPriceUpdated',
            'YourNamespace\\Omnibus\\Listeners\\PriceChangeListener'
        );
    }

    public function register()
    {
        // Bind services or singleton instances if needed
    }
}
