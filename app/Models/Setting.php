<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    protected $casts = ['value' => 'array'];

    public static function getValue(string $group, string $key, mixed $default = null): mixed
    {
        return Cache::remember("settings.{$group}.{$key}", 3600, fn () => static::where('group', $group)->where('key', $key)->value('value') ?? $default);
    }
}
