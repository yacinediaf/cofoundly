<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskCommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $attributes = Validator::validate($request->all(), [
            'content' => ['required'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        DB::transaction(function () use ($attributes, $task) {
            $task->comments()->create($attributes);
        });

        return back()->with('success', 'New Task Created successfully.');
    }
}
