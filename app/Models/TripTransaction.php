<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * TripTransaction Model
 *
 * Records individual financial transactions against a trip. Each transaction
 * is either an 'expense' (money spent during the trip) or a 'recovery'
 * (money earned/recovered). The payment_mode determines how the payment was
 * made: 'wallet' (driver's wallet), 'owner_bank' (owner's bank account),
 * or 'fastag' (electronic toll payment).
 *
 * When payment_mode is 'wallet', the transaction directly impacts the
 * driver's wallet balance (debit for expenses, credit for recoveries).
 *
 * @property int         $id
 * @property int         $trip_id               The trip this transaction belongs to
 * @property int         $added_by              User ID of who created this transaction
 * @property string      $transaction_type      Type: 'expense' or 'recovery'
 * @property int|null    $expense_category_id   Optional category for classifying expenses
 * @property float       $amount                Transaction amount in currency
 * @property string      $payment_mode          Payment method: 'wallet', 'owner_bank', or 'fastag'
 * @property string|null $bill_image_path       File path to the uploaded bill/receipt image
 * @property string|null $remarks               Additional notes or description
 */
class TripTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'trip_id',
        'added_by',
        'transaction_type',
        'expense_category_id',
        'amount',
        'payment_mode',
        'bill_image_path',
        'remarks',
    ];

    /**
     * Get the trip that this transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Get the expense category assigned to this transaction.
     * Only applicable when transaction_type is 'expense'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    /**
     * Get the user who created/added this transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}