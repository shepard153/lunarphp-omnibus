<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus;

use Illuminate\Support\ServiceProvider;
use Kkosmider\Omnibus\Observers\PriceObserver;
use Lunar\Models\Price;

class OmnibusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'omnibus.migrations');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/omnibus.php' => config_path('omnibus.php'),
        ], 'omnibus.config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/omnibus.php', 'omnibus'
        );

        Price::observe(PriceObserver::class);
    }

    public function register(): void
    {
        // Bind services or singleton instances if needed
    }
}
