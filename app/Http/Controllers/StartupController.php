<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Startup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StartupController extends Controller
{
    public function index()
    {
        return Inertia::render('Startups/Index', [
            //Get only active startups (with a defined data)
            'startups' => Startup::with('industry')->latest()->where('stage', '!=', null)->get()
        ]);
    }

    public function show(Request $request, Startup $startup)
    {
        return Inertia::render('Startups/Show', [
            'startup' => $startup->load(['industry', 'owner']),
            'members' => MemberResource::collection($startup->members()),
            'canRequest' => $request->user() ? $request->user()->canSendRequest($startup) : false,
            'alreadyRequested' => $request->user() ? $startup->hasPendingRequest($request->user()) : false,
            'isGuest' => is_null($request->user()),
        ]);
    }
}
