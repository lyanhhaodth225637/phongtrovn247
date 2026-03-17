<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table = 'provinces';
    protected $fillable = [
        'name',
        'slug',
        'code',
        'type',
        'lat',
        'lng',
        'zoom'
    ];
    public function wards() : HasMany
    {
        return $this->hasMany(Ward::class, 'province_id', 'id');
    }
}
