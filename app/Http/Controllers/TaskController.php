<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskStatusUpdated;
use App\Http\Requests\Tasks\ReplaceTaskRequest;
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
        $task = $project->tasks()->create($request->mappedAttributes());

        broadcast(new TaskCreated($task))->toOthers();

        return redirect(route('projects.show', $project))
                ->with('success', 'New Task Created successfully.');
    }

    public function edit(Project $project, Task $task)
    {
        $members = $project->team->allUsers();

        return Inertia::render('Tasks/Edit', [
            'task' => $task,
            'members' => $members,
            'project_code' => $project->project_code
        ]);
    }

    public function replace(ReplaceTaskRequest $request, Project $project, Task $task)
    {
        $task->update($request->mappedAttributes());

        return redirect(route('projects.show', $project))
                        ->with('success', 'Task Updated successfully.');
    }

    public function update(Request $request, Task $task)
    {
        //Update to a real policy or gate (TODO)
        if ($request->user()->id !== $task->assigned_to->id) {
            return back()->with('error', 'youre not allowed');
        }
        //validate
        $attributes = $request->validate([
            'status' => [Rule::enum(TaskStatus::class)]
        ]);
        //Update
        $task->updateStatus($attributes['status']);
        //Broadcast
        broadcast(new TaskStatusUpdated($task))->toOthers();
        //Return
        return back()->with('success', 'task status updated. ✅.');
    }

    public function delete(Project $project, Task $task)
    {
        $deletedTask = $task;
        $task->delete();
        broadcast(new TaskDeleted($deletedTask));
        return back()->with('success', 'task deleted with success ✅.');
    }
}
