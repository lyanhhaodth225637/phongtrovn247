<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemWalletTransaction extends Model
{
    protected $fillable = [
        'system_wallet_id',
        'wallet_transaction_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference_code',
        'description',
    ];

    public function systemWallet()
    {
        return $this->belongsTo(SystemWallet::class);
    }

    public function walletTransaction()
    {
        return $this->belongsTo(WalletTransaction::class);
    }
}