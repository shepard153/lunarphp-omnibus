<?php
declare(strict_types=1);

namespace Kkosmider\Omnibus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Lunar\Base\Traits\HasModelExtending;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;

class HistoricalPrice extends Model
{
    use HasModelExtending;

    protected $fillable = [
        'priceable_id',
        'priceable_type',
        'currency_id',
        'customer_group_id',
        'tier',
        'price',
        'recorded_at',
    ];

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
