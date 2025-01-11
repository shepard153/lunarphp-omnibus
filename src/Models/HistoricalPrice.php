<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Lunar\Base\BaseModel;
use Lunar\Base\Casts\Price as CastsPrice;
use Lunar\Base\Traits\HasModelExtending;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;

class HistoricalPrice extends BaseModel
{
    use HasModelExtending;

    protected $fillable = [
        'priceable_id',
        'priceable_type',
        'currency_id',
        'customer_group_id',
        'price',
        'recorded_at',
    ];

    protected $casts = [
        'price' => CastsPrice::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable('historical_prices');
    }

    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function customerGroup(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class);
    }
}
