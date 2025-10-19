<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\StartupRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class StartupRequestController extends Controller
{
    public function index(Startup $startup)
    {
        return Inertia::render('StartupRequests/Index', [
            'requests' => StartupRequest::pendingRequests($startup),
            'availableRoles' => array_values(Jetstream::$roles),
        ]);
    }

    public function store(Request $request, Startup $startup)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Create the startup request
        $request->user()->requests()->create([
            'message' => $request->message,
            'startup_id' => $startup->id
        ]);

        return back()->with('success', 'Request sent successfully.');
    }

    public function delete(StartupRequest $request)
    {
        $request->delete();

        return back()->with('success', 'Request deleted successfully.');
    }
}
