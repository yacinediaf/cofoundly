<?php

namespace App\Concerns;

use App\Models\Startup;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasStartups
{
    /**
     * Determine if the given startup is the current one.
     *
     * @param  mixed  $startup
     * @return bool
     */
    public function isCurrentStartup($startup)
    {
        return $startup->id === $this->currentStartup->id;
    }

    /**
     * Get the current startup of the user's context.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentStartup()
    {
        if (is_null($this->current_startup_id) && $this->id) {
            $this->switchStartup($this->personalStartup());
        }

        return $this->belongsTo(Startup::class, 'current_startup_id');
    }

    /**
     * Switch the user's context to the given startup.
     *
     * @param  mixed  $startup
     * @return bool
     */
    public function switchStartup($startup)
    {
        if (!$this->belongsToStartup($startup)) {
            return false;
        }

        $this->forceFill([
            'current_startup_id' => $startup->id,
        ])->save();

        $this->setRelation('currentStartup', $startup);

        if (!$this->switchTeam($startup->teams->first())) {
            return false;
        }

        return true;
    }

    /**
     * Get all of the startups the user owns or belongs to.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allStartups()
    {
        return $this->ownedStartups
        ->merge($this->startups())
        ->sortBy('name');
    }

    /**
     * Get all of the startups the user owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownedStartups(): HasMany
    {
        return $this->hasMany(Startup::class, 'owner_id');
    }

    /**
     * Get all of the startups the user belongs to.
     *
     * @return \Illuminate\Support\Collection
     */
    public function startups()
    {
        return Startup::whereIn(
            'id',
            $this->teams->pluck('startup_id')
            ->unique()
        )->get();
    }

    /**
     * Get the user's "personal" startup.
     *
     * @return \App\Models\Startup
     */
    public function personalstartup()
    {
        return $this->ownedStartups->where('personal_startup', true)->first();
    }

    /**
     * Determine if the user owns the given startup.
     *
     * @param  mixed  $startup
     * @return bool
     */
    public function ownsStartup($startup)
    {
        if (is_null($startup)) {
            return false;
        }

        return $this->id == $startup->owner_id;
    }

    /**
     * Determine if the user belongs to the given startup.
     *
     * @param  mixed  $startup
     * @return bool
     */
    public function belongsToStartup($startup)
    {
        if (is_null($startup)) {
            return false;
        }

        return $this->ownsStartup($startup) || $this->startups()->contains(function ($t) use ($startup) {
            return $t->id === $startup->id;
        });
    }
}
