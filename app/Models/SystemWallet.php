<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
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
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('system_wallet')
            ->logOnly([
                'bank_name',
                'account_name',
                'account_number',
                'is_active',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'is_active' => 'boolean',
        'balance' => 'integer',
    ];

    public function notifications()
    {
        return $this->hasMany(SystemWalletNotification::class);
    }
}