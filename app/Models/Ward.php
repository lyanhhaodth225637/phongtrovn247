<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    protected $table = 'wards';
    protected $fillable = [
        'province_id',
        'name',
        'slug',
        'code',
        'type',
        'lat',
        'lng',
        'zoom'
    ];

    //hasMany
    public function post(): HasMany
    {
        return $this->hasMany(Post::class, 'ward_id', 'id');
    }

    //belongTo
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}