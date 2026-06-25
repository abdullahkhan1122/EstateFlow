<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ViewingRequest extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'rescheduled', 'completed', 'cancelled', 'no_show'];

    protected $fillable = [
        'property_id', 'user_id', 'agent_id', 'preferred_date', 'preferred_time', 'viewing_type',
        'status', 'name', 'email', 'phone', 'message', 'agent_notes', 'confirmed_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'confirmed_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
