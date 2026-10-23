<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['subscription_package_id', 'user_id'])]
class SubscriptionPackageUser extends Model {

    public function subscriptionPackage(): BelongsTo {
        return $this->belongsTo(SubscriptionPackage::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
