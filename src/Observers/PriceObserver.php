<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Observers;

use Kkosmider\Omnibus\Enums\TrackingMode;
use Kkosmider\Omnibus\Models\HistoricalPrice;
use Lunar\Models\Price;

class PriceObserver
{
    public function updated(Price $price): void
    {
        if (!config('omnibus.enabled', true)) {
            return;
        }

        $trackingMode = TrackingMode::tryFrom(config('omnibus.tracking_mode'));

        if ($trackingMode === null) {
            $trackingMode = TrackingMode::ALL;
        }

        if ($price->wasChanged('price')) {
            if ($trackingMode === TrackingMode::ALL) {
                HistoricalPrice::query()->create([
                    'priceable_id'      => $price->priceable_id,
                    'priceable_type'    => $price->priceable_type,
                    'currency_id'       => $price->currency_id,
                    'customer_group_id' => $price->customer_group_id,
                    'price'             => $price->price->value,
                    'recorded_at'       => now(),
                ]);
            }

            if ($trackingMode === TrackingMode::LATEST) {
                $existingLowest = HistoricalPrice::query()
                    ->where([
                        'priceable_id'      => $price->priceable_id,
                        'priceable_type'    => $price->priceable_type,
                        'currency_id'       => $price->currency_id,
                        'customer_group_id' => $price->customer_group_id,
                    ])
                    ->orderBy('price')
                    ->value('price')
                    ?->value;

                if (is_null($existingLowest) || $price->price->value < $existingLowest) {
                    HistoricalPrice::query()->latest('recorded_at')->updateOrCreate([
                        'priceable_id'      => $price->priceable_id,
                        'priceable_type'    => $price->priceable_type,
                        'currency_id'       => $price->currency_id,
                        'customer_group_id' => $price->customer_group_id,
                    ], [
                        'price'       => $price->price->value,
                        'recorded_at' => now(),
                    ]);
                }
            }
        }
    }
}
