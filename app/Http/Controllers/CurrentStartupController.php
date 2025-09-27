<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class CurrentStartupController extends Controller
{
    /**
     * Update the authenticated user's current team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $startup = Startup::findOrFail($request->startup_id);

        if (!$request->user()->switchStartup($startup)) {
            abort(403);
        }

        return redirect(route('dashboard'), 303);
    }
}
