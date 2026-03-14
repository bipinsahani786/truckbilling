<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ExpenseCategory extends Model
{
    protected $fillable = ['owner_id', 'name', 'is_system_default'];

    // protected static function booted()
    // {
    //     // Fetch categories that belong to the owner OR are system defaults
    //     static::addGlobalScope('owner_or_default', function (Builder $builder) {
    //         if (Auth::check()) {
    //             $ownerId = Auth::user()->owner_id ?? Auth::id();
    //             $builder->where('owner_id', $ownerId)
    //                     ->orWhereNull('owner_id');
    //         }
    //     });
    // }
}
