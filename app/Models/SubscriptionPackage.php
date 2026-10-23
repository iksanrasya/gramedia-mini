<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name_package', 'description', 'color', 'price'])]
class SubscriptionPackage extends Model
{
    public function subscriptionPackageUser(): HasMany
    {
        return $this->hasMany(SubscriptionPackageUser::class);
    }

    public function subscriptionPackageBook(): HasMany
    {
        return $this->hasMany(SubscriptionPackageBook::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(SubscriptionPackageUser::class);
    }
}
