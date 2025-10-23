<?php

use App\Models\Project;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('projects.{project_code}', function ($user, $project_code) {
    $project = Project::where('project_code', $project_code)->first();
    if (!in_array($user->id, $project->team->allUsers()->pluck('id')->toArray())) {
        return false;
    }

    return true;
});

Broadcast::channel('projects.{project_code}.tasks.{task_id}', function ($user, $project_code, $task_id) {
    $project = Project::where('project_code', $project_code)->first();
    if (!in_array($user->id, $project->team->allUsers()->pluck('id')->toArray())) {
        return false;
    }

    return true;
});
