<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus;

use Kkosmider\Omnibus\Filament\Resources\HistoricalPriceResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class OmnibusPlugin implements Plugin
{
    public function getId(): string
    {
        return 'omnibus';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            HistoricalPriceResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
