<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
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

    public function store(Request $request, Project $project)
    {
        $attributes = $request->validate([
            'title' => ['string', 'max:255', 'required'],
            'description' => ['required'],
            'assignedTo' => ['required', 'exists:users,id'],
            'deliveryDate' => ['required', 'date_format:Y-m-d']
        ]);

        $project->tasks()->create($attributes);

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
        return back()->with('success', 'task status updated. ✅');
    }
}
