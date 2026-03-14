<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use BelongsToOwner;
    protected $fillable = ['driver_id', 'balance', 'status'];

    public function driver() { return $this->belongsTo(User::class, 'driver_id'); }
    public function transactions() { return $this->hasMany(WalletTransaction::class); }
}
