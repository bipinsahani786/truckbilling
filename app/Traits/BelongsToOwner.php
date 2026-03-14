<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

trait BelongsToOwner
{
    protected static function bootBelongsToOwner()
    {
        // 1. Automatically filter data based on the logged-in user's owner_id
        static::addGlobalScope('owner', function (Builder $builder) {
            if (Auth::check()) {
                // Agar user owner hai toh uska khud ka ID, nahi toh driver ka owner_id
                $ownerId = Auth::user()->owner_id ?? Auth::id();
                $builder->where('owner_id', $ownerId);
            }
        });

        // 2. Automatically inject owner_id when creating a new record
        static::creating(function ($model) {
            if (Auth::check() && empty($model->owner_id)) {
                $ownerId = Auth::user()->owner_id ?? Auth::id();
                $model->owner_id = $ownerId;
            }
        });
    }

    // Relationship setup (Optional but very helpful)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}