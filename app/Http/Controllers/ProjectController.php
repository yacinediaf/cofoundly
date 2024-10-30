<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectsResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        //Get all the current user's projects with the partipants
        $projects = Project::query()
                            ->with(['team.users', 'team.owner'])
                            ->whereIn('team_id', auth()->user()->allTeams()->pluck('id'))
                            ->get();

        return Inertia::render(
            'Projects/Index',
            ['projects' => ProjectsResource::collection($projects)]
        );
    }

    public function show(Project $project)
    {
        //get current team
        $currentTeam = auth()->user()->currentTeam->id;
        //then check if the project chosen belongs to current team
        if ($project->team_id !== $currentTeam) {
            //if not switch team
            auth()->user()->switchTeam($project->team);
        }
        return Inertia::render('Projects/Show', compact('project'));
    }

    public function store(Request $request)
    {
        //validate request
        $attributes = $request->validate([
            'title' => 'required|min:5',
            'description' => 'nullable'
        ]);
        //check if user has permission (to-do)
        $user = auth()->user();

        if (!$user->hasTeamPermission($user->currentTeam, 'create')) {
            return back()->with('error', 'not allowed to perform this action');
        }

        //create the project on the current team
        $user->currentTeam
        ->projects()
        ->create($attributes);

        //return back
        return back()->with('success', 'Done, Project created successfully. ✅');
    }
}
