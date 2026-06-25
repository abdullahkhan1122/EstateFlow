<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    protected $fillable = ['user_id', 'email_inquiries', 'email_viewings', 'email_saved_search_matches', 'database_notifications'];

    protected $casts = [
        'email_inquiries' => 'boolean',
        'email_viewings' => 'boolean',
        'email_saved_search_matches' => 'boolean',
        'database_notifications' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
