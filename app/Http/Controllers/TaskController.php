<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function update(Request $request, Task $task)
    {
        $attributes = $request->validate([
            'status' => [Rule::enum(TaskStatus::class)]
        ]);

        tap($task, function (Task $task) use ($attributes) {
            $task->status = $attributes['status'];
            $task->save();
        });

        //return back
        return back()->with('success', 'task status updated. ✅');
    }
}
