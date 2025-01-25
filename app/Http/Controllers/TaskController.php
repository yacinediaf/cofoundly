<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Events\TaskDeleted;
use App\Events\TaskStatusUpdated;
use App\Http\Requests\Tasks\ReplaceTaskRequest;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $project = $project->setRelation('team', auth()->user()->currentTeam);
        $members = $project->team->allUsers();

        return Inertia::render('Tasks/Create', [
            'members' => $members,
            'project' => $project->load('tags')
        ]);
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        DB::transaction(function () use ($request, $project) {
            $project->createTask(
                $request->mappedAttributes(),
                $request->tags
            );
        });

        return redirect(route('projects.show', $project))
                ->with('success', 'New Task Created successfully.');
    }

    public function edit(Project $project, Task $task)
    {
        $project = $project->setRelation('team', auth()->user()->currentTeam);
        $members = $project->team->allUsers();

        return Inertia::render('Tasks/Edit', [
            'task' => $task,
            'members' => $members,
            'project' => $project->load('tags')
        ]);
    }

    public function replace(ReplaceTaskRequest $request, Project $project, Task $task)
    {
        DB::transaction(function () use ($task, $request) {
            tap($task, function ($task) use ($request) {
                $task->update($request->mappedAttributes());
                $task->assignTags($request->tags);
            });
        });

        return redirect(route('projects.show', $project))
                        ->with('success', 'Task Updated successfully.');
    }

    public function update(Request $request, Task $task)
    {
        //Update to a real policy or gate (TODO)
        if ($request->user()->id !== $task->assignedTo->id) {
            return back()->with('error', 'youre not allowed');
        }
        //validate
        $attributes = $request->validate([
            'status' => [Rule::enum(TaskStatus::class)]
        ]);
        //Update status
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
