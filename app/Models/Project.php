<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Events\TaskCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->project_code = Str::random(6);
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function members()
    {
        return $this->team->users();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function createTask($attributes, $tags)
    {
        $task = $this->tasks()
                    ->create($attributes)
                    ->assignTags($tags);
        broadcast(new TaskCreated($task))->toOthers();
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function addTag(array $attributes)
    {
        return $this->tags()->create($attributes);
    }

    public function WithGroupedTasks($tags = [])
    {
        return $this->load(['tasks.assignedTo', 'tasks.tags', 'tasks' => function ($query) use ($tags) {
            $query->when($tags, function ($query) use ($tags) {
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('id', array_values($tags));
                });
            });
        }])->tasks;
    }

    public function scopeWithTasksStatistics(Builder $query)
    {
        return $query->withCount(
            [
                'tasks',
                'tasks as todo_tasks_count' => function (Builder $query) {
                    $query->where('status', TaskStatus::TODO);
                },
                'tasks as in_progress_tasks_count' => function (Builder $query) {
                    $query->where('status', TaskStatus::INPROGRESS);
                },
                'tasks as done_tasks_count' => function (Builder $query) {
                    $query->where('status', TaskStatus::DONE);
                }
            ]
        );
    }
}
