<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryActivity extends Model
{
    protected $fillable = ['property_inquiry_id', 'user_id', 'type', 'description', 'metadata'];

    protected $casts = ['metadata' => 'array'];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(PropertyInquiry::class, 'property_inquiry_id');
    }
}
