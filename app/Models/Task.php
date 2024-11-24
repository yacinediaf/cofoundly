<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['tags'];

    protected function casts()
    {
        return [
            'created_at' => 'datetime:l,jS'
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeByStatus(Builder $query): Collection
    {
        return $query->get()->groupBy('status');
    }
}
