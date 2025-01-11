<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kkosmider\Omnibus\Models\HistoricalPrice;

trait HasHistoricalPrices
{
    public function prices(): MorphMany
    {
        return $this->morphMany(
            HistoricalPrice::modelClass(),
            'priceable'
        );
    }
    public function getHistoricalPrice($days = 30)
    {
        return $this->where('priceable_type', $this->getMorphClass())
            ->where('recorded_at', '>=', now()->subDays($days))
            ->latest('recorded_at')
            ->first();
    }

    public function getLatestHistoricalPrice($purchasable, $currencyId, $customerGroupId = null, $tier = 1, $days = 30)
    {
        return HistoricalPrice::where('purchasable_id', $purchasable->id)
            ->where('purchasable_type', get_class($purchasable))
            ->where('currency_id', $currencyId)
            ->where('customer_group_id', $customerGroupId)
            ->where('tier', $tier)
            ->where('recorded_at', '>=', now()->subDays($days))
            ->latest('recorded_at')
            ->first();
    }
}
