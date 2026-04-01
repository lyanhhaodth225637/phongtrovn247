<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemWallet extends Model
{
    protected $fillable = [
        'name',
        'bank_name',
        'account_name',
        'account_number',
        'balance',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'balance' => 'integer',
    ];

    public function notifications()
    {
        return $this->hasMany(SystemWalletNotification::class);
    }
}