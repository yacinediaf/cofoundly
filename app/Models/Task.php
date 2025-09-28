<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (Task $task) {
            $task->assigned_at = today();
            $task->status = TaskStatus::TODO;
        });
    }

    protected function casts()
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'delivery_date' => 'datetime:Y-m-d',
        ];
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get:fn ($value) => Str::markdown($value)
        );
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function assignTags(array|null $tags)
    {
        if ((!is_null($tags))) {
            $this->syncTags($tags);
        }
        return $this;
    }

    public function syncTags($tags)
    {
        return $this->tags()->sync($tags);
    }

    public function scopeByStatus(Builder $query): Collection
    {
        return $query->get()
                ->groupBy('status');
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
    }
}
