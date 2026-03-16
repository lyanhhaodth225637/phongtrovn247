<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //table riêng lẽ nên k cần hasmany
    protected $fillable = [
        'name',
        'slug',
        'code',
        'type',
        'lat',
        'lng',
        'zoom'
    ];
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
