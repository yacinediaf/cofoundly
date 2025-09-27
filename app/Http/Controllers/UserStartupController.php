<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserStartupController extends Controller
{
    public function create()
    {
        return Inertia::render('UserStartups/Create', [
            'wilayas' => config('wilayas')
        ]);
    }

    public function store(Request $request)
    {
        $attributes = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:startups,name',
            'description' => 'required|string|max:255',
            'website' => 'sometimes|max:255',
            'location' => [
                'required',
                'in:' . Rule::in(
                    collect(config('wilayas'))
                    ->pluck('id')
                    ->toArray()
                )
            ],
        ])->validate();

        DB::transaction(function () use ($request, $attributes) {
            // create startup
            $startup = $request->user()->ownedStartups()
            ->create(array_merge($attributes, [
                'personal_startup' => false
            ]));
            // create team
            $startup->teams()->create([
                'user_id' => $request->user()->id,
                'name' => explode(' ', $startup->name, 2)[0] . "'s Team",
                'personal_team' => false
            ]);
            // switch current startup and current team
            $request->user()->switchStartup($startup);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Startup created successfully.');
    }

    public function show(Startup $startup)
    {
        return Inertia::render('UserStartups/Show', [
            'startup' => $startup,
            'wilayas' => config('wilayas')
        ]);
    }

    public function update(Request $request, Startup $startup)
    {
        $attributes = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'website' => 'sometimes|max:255',
            'location' => [
                'required',
                'in:' . Rule::in(
                    collect(config('wilayas'))
                    ->pluck('id')
                    ->toArray()
                )
            ],
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ])->validate();

        if (isset($attributes['logo'])) {
            $startup->updateLogo($attributes['logo']);
        }
        if (isset($attributes['banner'])) {
            $startup->updateBanner($attributes['banner']);
        }

        $startup->update([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'website' => $attributes['website'],
            'location' => $attributes['location'],
        ]);

        return redirect()->back();
    }
}
