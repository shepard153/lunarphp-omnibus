<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kkosmider\Omnibus\Models\HistoricalPrice;

trait HasHistoricalPrices
{
    public function historicalPrices(): MorphMany
    {
        return $this->morphMany(
            HistoricalPrice::modelClass(),
            'priceable'
        );
    }
    public function getHistoricalLowestPrice(int $days = 30): HistoricalPrice
    {
        return HistoricalPrice::query()
            ->where('priceable_id', $this->getKey())
            ->where('priceable_type', $this->getMorphClass())
            ->where('recorded_at', '>=', now()->subDays($days))
            ->orderBy('price')
            ->first();
    }
}
