<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Post extends Model
{
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
        'expires_at'
    ];

    // HasMany
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }
    public function postModerations(): HasMany
    {
        return $this->hasMany(PostModeration::class, 'post_id', 'id');
    }
    
    // Post.php


    // BeLongTo
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


    // many-to-many
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'post_amenities');
    }

}