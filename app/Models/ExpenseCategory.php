<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ExpenseCategory Model
 *
 * Represents a category used to classify trip expenses (e.g., Diesel, Toll, Food).
 * Categories can be either system-wide defaults (created by super-admin) or
 * custom categories created by individual fleet owners.
 *
 * System default categories (is_system_default = true) are visible to all owners.
 * Owner-specific categories are only visible to the owner who created them.
 *
 * @property int       $id
 * @property int|null  $owner_id           The owner who created this category (null for system defaults)
 * @property string    $name               Category display name (stored in uppercase)
 * @property bool      $is_system_default  Whether this is a global system-wide category
 */
class ExpenseCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['owner_id', 'name', 'is_system_default'];
}
