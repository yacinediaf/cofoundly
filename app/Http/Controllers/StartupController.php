<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Inertia\Inertia;

class StartupController extends Controller
{
    public function index()
    {
        return Inertia::render('Startups/Index', [
            'startups' => Startup::latest()->get()
        ]);
    }

    public function show(Startup $startup)
    {
        return Inertia::render('Startups/Show', [
            'startup' => $startup
        ]);
    }
}
