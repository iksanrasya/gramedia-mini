<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subscriptionPackageUser(): HasMany
    {
        return $this->hasMany(SubscriptionPackageUser::class);
    }

    public function checkout(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(SubscriptionPackage::class, 'subscription_package_users')
            ->withPivot('expired_date')
            ->withTimestamps();
    }

    public function activeSubscription(): ?SubscriptionPackage
    {
        return $this->subscriptions()
            ->wherePivot('expired_date', '>=', now()->toDateString())
            ->orderByDesc('subscription_package_users.expired_date')
            ->first();
    }

    public function isSubscribed(): bool
    {
        return $this->activeSubscription() !== null;
    }
}
