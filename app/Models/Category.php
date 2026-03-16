<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
        //1 category → nhiều location
    }
}
