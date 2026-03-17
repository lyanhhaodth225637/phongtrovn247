<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'address',
        'latitude',
        'longitude',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
        
    }
}
