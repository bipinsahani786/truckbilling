<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripTransaction extends Model
{
    protected $fillable = [
        'trip_id', 'added_by', 'transaction_type', 'expense_category_id', 
        'amount', 'payment_mode', 'bill_image_path', 'remarks'
    ];

    public function trip() { return $this->belongsTo(Trip::class); }
    public function category() { return $this->belongsTo(ExpenseCategory::class, 'expense_category_id'); }
    public function addedBy() { return $this->belongsTo(User::class, 'added_by'); }
}