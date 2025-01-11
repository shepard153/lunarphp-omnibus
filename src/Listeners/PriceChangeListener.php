<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Listeners;

use Kkosmider\Omnibus\Models\HistoricalPrice;

class PriceChangeListener
{
    public function handle($event)
    {
        $purchasable = $event->purchasable;

        foreach ($purchasable->prices as $price) {
            $latestPrice = HistoricalPrice::where('purchasable_id', $purchasable->id)
                ->where('purchasable_type', get_class($purchasable))
                ->where('currency_id', $price->currency_id)
                ->where('customer_group_id', $price->customer_group_id)
                ->where('tier', $price->tier)
                ->latest('recorded_at')
                ->first();

            if (!$latestPrice || $latestPrice->price != $price->price->value) {
                HistoricalPrice::create([
                    'purchasable_id' => $purchasable->id,
                    'purchasable_type' => get_class($purchasable),
                    'currency_id' => $price->currency_id,
                    'customer_group_id' => $price->customer_group_id,
                    'tier' => $price->tier,
                    'price' => $price->price->value,
                    'recorded_at' => now(),
                ]);
            }
        }
    }
}
