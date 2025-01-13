<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Filament\Resources\HistoricalPriceResource\Pages;

use Kkosmider\Omnibus\Filament\Resources\HistoricalPriceResource;
use Filament\Resources\Pages\ManageRecords;

class ManageHistoricalPrice extends ManageRecords
{
    protected static string $resource = HistoricalPriceResource::class;
}
