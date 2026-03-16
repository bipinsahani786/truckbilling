<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Model;

/**
 * Wallet Model
 *
 * Represents a driver's digital wallet used to track cash advances,
 * trip expenses, and recoveries. Each driver has exactly one wallet
 * that is automatically created when the driver is registered.
 *
 * @property int    $id
 * @property int    $owner_id      The fleet owner who manages this wallet
 * @property int    $driver_id     The driver to whom this wallet belongs
 * @property float  $balance       Current available balance in the wallet
 * @property string $status        Wallet status: 'active' or 'frozen'
 */
class Wallet extends Model
{
    use BelongsToOwner;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['owner_id', 'driver_id', 'balance', 'status'];

    /**
     * Get the driver (User) who owns this wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Get all transaction records associated with this wallet.
     * Includes both credit (money added) and debit (money spent) entries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
