<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
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

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}