<?php

namespace App\Actions\Fortify;

use App\Models\Startup;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $startup = $this->createStartup($user);
                $this->createTeam($startup);
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createStartup(User $user): Startup
    {
        return $user->ownedStartups()->create([
            'owner_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Startup",
            'personal_startup' => true,
        ]);
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(Startup $startup): void
    {
        $startup->teams()->create([
            'user_id' => $startup->owner_id,
            'name' => explode(' ', $startup->name, 2)[0] . ' Team',
            'personal_team' => true,
        ]);
    }
}
