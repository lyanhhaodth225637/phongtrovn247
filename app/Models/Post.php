<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{
    use LogsActivity;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'category_id',
        'ward_id',
        'membership_id',
        'title',
        'slug',
        'description',
        'price',
        'area',
        'address',
        'latitude',
        'longitude',
        'status',
        'is_visible_admin',
        'is_visible_owner',
        'expires_at',
        'pushed_at',
        'push_count',
        'price_unit',
        'view_count',
        'admin_note',
        'approved_by',
        'approved_at',
    ];
    protected $casts = [
        'pushed_at' => 'datetime',
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('post')
            ->logOnly([
                'title',
                'price',
                'area',
                'address',
                'status',
                'is_visible_admin',
                'is_visible_owner',
                'expires_at',
                'pushed_at',
                'push_count',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function postModerations(): HasMany
    {
        return $this->hasMany(PostModeration::class, 'post_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'post_amenities');
    }
    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_posts')
            ->withTimestamps();
    }
    public function reports(): HasMany
    {
        return $this->hasMany(PostReport::class, 'post_id', 'id');
    }
}