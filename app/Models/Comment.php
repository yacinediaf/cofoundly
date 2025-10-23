<?php

namespace App\Models;

use App\Events\CommentDeleted;
use App\Events\CommentUpdated;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comment extends Model
{
    protected $guarded = [];

    public function reformulate($content)
    {
        $this->content = $content;
        $this->save();

        $this->load('user', 'task');

        broadcast(new CommentUpdated(CommentResource::make($this), $this->task))->toOthers();
    }

    public function erase()
    {
        $this->load('task.project');
        $task = $this->task;
        $commentId = $this->id;
        $this->delete();

        broadcast(new CommentDeleted($commentId, $task))->toOthers();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get:fn ($value) => Str::markdown($value)
        );
    }
}
