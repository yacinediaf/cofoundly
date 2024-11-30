<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $members = $project->team->allUsers();

        return Inertia::render('Tasks/Create', [
            'members' => $members,
            'project' => $project
        ]);
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->mappedAttributes());

        return redirect(route('projects.show', $project))
                ->with('success', 'New Task Created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        //validate
        $attributes = $request->validate([
            'status' => [Rule::enum(TaskStatus::class)]
        ]);
        //Update
        $task->updateStatus($attributes['status']);
        //Return
        return back()->with('success', 'task status updated. ✅.');
    }

    public function delete(Project $project, Task $task)
    {
        $task->delete();

        return back()->with('success', 'task deleted with success ✅.');
    }
}
