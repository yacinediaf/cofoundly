<?php

namespace App\Http\Controllers;

use App\Models\Startup;
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

    public function show(Startup $startup)
    {
        return Inertia::render('Startups/Show', [
            'startup' => $startup->load(['industry', 'owner']),
            'members' => $startup->members(),
        ]);
    }
}
