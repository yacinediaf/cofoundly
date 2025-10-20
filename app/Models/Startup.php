<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Startup extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'logo_url',
        'banner_url',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(StartupRequest::class);
    }

    public function hasPendingRequest(User $user)
    {
        return $this->requests()
        ->where('user_id', $user->id)
        ->where('status', 'pending')
        ->exists();
    }

    public function members()
    {
        return $this->teams->map(function ($team) {
            return $team->users;
        })->flatten()->unique('id');
    }

    public function isMember(User $user)
    {
        return $this->members()->contains('id', $user->id);
    }

    protected function description(): ?Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Str::markdown($value) : null
        );
    }

    protected function lookingFor(): ?Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Str::markdown($value) : null
        );
    }

    protected function location(): Attribute
    {
        return Attribute::get(function ($value) {
            return collect(config('wilayas'))->where('id', $value)->first();
        });
    }

    protected function logoUrl(): Attribute
    {
        return new Attribute(get: function () {
            return $this->logo_path ? Storage::disk('public')->url($this->logo_path) : null;
        });
    }

    protected function bannerUrl(): Attribute
    {
        return new Attribute(get: function () {
            return $this->banner_path ? Storage::disk('public')->url($this->banner_path) : null;
        });
    }

    public function updateLogo(UploadedFile $logo, $storagePath = 'startup-logos')
    {
        tap($this->logo_path, function ($previous) use ($logo, $storagePath) {
            $this->forceFill([
                'logo_path' => $logo->storePublicly(
                    $storagePath,
                    ['disk' => 'public']
                ),
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    public function updateBanner(UploadedFile $banner, $storagePath = 'startup-banners')
    {
        tap($this->banner_path, function ($previous) use ($banner, $storagePath) {
            $this->forceFill([
                'banner_path' => $banner->storePublicly(
                    $storagePath,
                    ['disk' => 'public']
                ),
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    public function deleteLogo()
    {
        if (is_null($this->logo_path)) {
            return;
        }

        Storage::disk('public')->delete($this->logo_path);

        $this->forceFill([
            'logo_path' => null,
        ])->save();
    }

    public function deleteBanner()
    {
        if (is_null($this->banner_path)) {
            return;
        }

        Storage::disk('public')->delete($this->banner_path);

        $this->forceFill([
            'banner_path' => null,
        ])->save();
    }
}
