<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\{Arr, Str};
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $jetstreamAuthUser = Inertia::getShared('auth.user')();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => function () use ($jetstreamAuthUser, $request) {
                    return $request->user() ?
                     array_merge(
                         $jetstreamAuthUser,
                         ['team_projects' => $request->user()->currentProjects ?? []]
                     )
                     : '';
                }
            ],
            'notifications' => collect(Arr::only($request->session()->all(), ['success', 'error']))
                                ->mapWithKeys(function ($notification, $key) {
                                    return ['type' => $key, 'body' => Str::title($notification)];
                                })
        ]);
    }
}
