<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:255'],
            'color' => 'required'
        ]);

        $project->addTag($attributes);

        return redirect()
                ->back()
                ->with('success', 'Tag created successfully.');
    }

    public function update(Request $request, Tag $tag)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('tags')->ignore($tag)],
            'color' => 'required'
        ]);

        $tag->update($attributes);

        return redirect(route('projects.show', $tag->project))
                ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect(route('projects.show', $tag->project))
                ->with('success', 'Tag deleted successfully.');
    }
}
