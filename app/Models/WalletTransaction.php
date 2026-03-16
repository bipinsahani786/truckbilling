<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * WalletTransaction Model
 *
 * Records every financial movement in a driver's wallet. Each transaction
 * represents either a 'credit' (money added) or 'debit' (money deducted).
 * Transactions are linked to trips via polymorphic reference for full audit trail.
 *
 * @property int         $id
 * @property int         $wallet_id       The wallet this transaction belongs to
 * @property string      $type            Transaction direction: 'credit' or 'debit'
 * @property float       $amount          The monetary value of this transaction
 * @property string      $description     Human-readable description of the transaction
 * @property int|null    $reference_id    Polymorphic reference ID (e.g., Trip ID)
 * @property string|null $reference_type  Polymorphic reference type (e.g., App\Models\Trip)
 */
class WalletTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'description',
        'reference_id',
        'reference_type',
    ];

    /**
     * Get the wallet that this transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the referenced entity (polymorphic relation).
     * This can point to a Trip or any other model that triggered this transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reference()
    {
        return $this->morphTo();
    }
}
