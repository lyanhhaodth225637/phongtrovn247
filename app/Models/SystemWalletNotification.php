<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemWalletNotification extends Model
{
    protected $fillable = [
        'system_wallet_id',
        'wallet_transaction_id',
        'sender_name',
        'sender_account_number',
        'receiver_account_number',
        'bank_name',
        'amount',
        'transfer_content',
        'raw_message',
        'match_status',
        'handled_by',
        'notified_at',
        'handled_at',
        'admin_note',
    ];

    public function walletTransaction()
    {
        return $this->belongsTo(WalletTransaction::class);
    }

    public function systemWallet()
    {
        return $this->belongsTo(SystemWallet::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}