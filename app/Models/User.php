<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\HasStartups;
use App\Notifications\StartupJoinRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use HasStartups;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ownedStartups(): HasMany
    {
        return $this->hasMany(Startup::class, 'owner_id');
    }

    public function sendRequest($startup, $message)
    {
        $this->requests()->create([
            'message' => $message,
            'startup_id' => $startup->id
        ]);

        $startup->owner->notify(new StartupJoinRequest($this, $startup));
    }

    public function canSendRequest(Startup $startup)
    {
        return !$startup->isMember($this)
        && $startup->owner_id != $this->id;
    }

    public function allProjects()
    {
        return $this->hasManyThrough(
            Project::class,
            Membership::class,
            'user_id',
            'team_id',
            'id',
            'user_id'
        );
    }

    /**
     * Get the user's current team projects.
     *
     */
    public function currentProjects()
    {
        return $this->currentTeam->projects();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(StartupRequest::class);
    }
}
