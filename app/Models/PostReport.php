<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PostReport extends Model
{
    use LogsActivity;

    protected $table = 'post_reports';

    protected $fillable = [
        'post_id',
        'reporter_id',
        'reason_type',
        'reason_detail',
        'status',
        'handled_by',
        'handled_at',
        'admin_note',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('post_report')
            ->logOnly([
                'post_id',
                'reporter_id',
                'reason_type',
                'reason_detail',
                'status',
                'handled_by',
                'handled_at',
                'admin_note',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id', 'id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by', 'id');
    }
}