<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class StartupRequest extends Model
{
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->code = Str::uuid()->toString();
        });
    }

    public function startup(): BelongsTo
    {
        return $this->belongsTo(Startup::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePendingRequests($query, Startup $startup)
    {
        $this->setRelation('startup', $startup);
        return $query->with(['user'])
           ->where('startup_id', $startup->id)
           ->where('status', 'pending')
           ->latest()
           ->get();
    }
}
