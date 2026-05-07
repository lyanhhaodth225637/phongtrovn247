<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class WalletTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_code',
        'payment_code',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'payment_gateway',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'transfer_content',
        'status',
        'description',
        'transactionable_type',
        'transactionable_id',
        'approved_by',
        'requested_at',
        'processed_at',
        'admin_note',
    ];
    
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('wallet')
            ->logOnly([
                'type',
                'amount',
                'status',
                'balance_before',
                'balance_after',
                'description',
                'approved_by',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function systemWalletNotifications()
    {
        return $this->hasMany(SystemWalletNotification::class);
    }

}