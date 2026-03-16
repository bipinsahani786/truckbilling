<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * BelongsToOwner Trait
 *
 * Provides multi-tenancy support by automatically scoping queries and
 * injecting ownership on models that belong to a fleet owner.
 *
 * This trait does two things:
 * 1. Adds a global scope that filters all queries to only return records
 *    belonging to the current user's owner (ensuring data isolation).
 * 2. Automatically sets the owner_id when creating new records, so the
 *    calling code doesn't need to manually assign it every time.
 */
trait BelongsToOwner
{
    /**
     * Boot the trait and register global scope + creating event.
     *
     * @return void
     */
    protected static function bootBelongsToOwner()
    {
        /**
         * Global Scope: Automatically filter all queries by the current owner.
         *
         * If the logged-in user is an owner, their own ID is used.
         * If the logged-in user is a driver, their parent owner_id is used.
         * This ensures drivers can only see data belonging to their fleet owner.
         */
        static::addGlobalScope('owner', function (Builder $builder) {
            if (Auth::check()) {
                $ownerId = Auth::user()->owner_id ?? Auth::id();
                $builder->where('owner_id', $ownerId);
            }
        });

        /**
         * Creating Event: Automatically inject owner_id into new records.
         *
         * When a new record is being created and owner_id is not already set,
         * this will automatically assign the resolved owner ID. This removes
         * the need to manually pass owner_id in every create() call.
         */
        static::creating(function ($model) {
            if (Auth::check() && empty($model->owner_id)) {
                $ownerId = Auth::user()->owner_id ?? Auth::id();
                $model->owner_id = $ownerId;
            }
        });
    }

    /**
     * Define the relationship to the fleet owner (User model).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}