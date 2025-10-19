<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;
use Laravel\Jetstream\Contracts\AddsTeamMembers;

class StartupMemberController extends Controller
{
    public function store(Request $request, $startupId)
    {
        $startupPersonalTeam = Startup::findOrFail($startupId)
        ->teams()
        ->where('personal_team', true)
        ->first();

        app(AddsTeamMembers::class)->add(
            $request->user(),
            $startupPersonalTeam,
            $request->email ?: '',
            $request->role
        );

        return back(303)->with('success', 'Member added successfully.');
    }
}
