<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'assigned_agent_id',
        'lead_source_id',
        'name',
        'email',
        'phone',
        'preferred_contact',
        'status',
        'priority',
        'follow_up_at',
        'last_contacted_at',
        'next_action',
        'lost_reason',
        'is_converted',
        'message',
        'internal_notes',
    ];

    protected $casts = [
        'follow_up_at' => 'datetime',
        'last_contacted_at' => 'datetime',
        'is_converted' => 'boolean',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(InquiryActivity::class);
    }
}
