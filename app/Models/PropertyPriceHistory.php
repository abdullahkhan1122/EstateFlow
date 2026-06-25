<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyPriceHistory extends Model
{
    protected $fillable = ['property_id', 'previous_price', 'new_price', 'changed_by', 'changed_at'];

    protected $casts = [
        'previous_price' => 'decimal:2',
        'new_price' => 'decimal:2',
        'changed_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
