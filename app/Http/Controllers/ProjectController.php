<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        //validate request
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]);
        //check if user has permission (to-do)
        /**
         * @var User $user
         */
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
