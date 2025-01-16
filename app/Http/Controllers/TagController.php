<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:tags|max:255',
            'color' => 'required'
        ]);

        $project->tags()->create($attributes);

        return redirect(route('projects.show', $project))
                ->with('success', 'Tag created successfully.');
    }
}
