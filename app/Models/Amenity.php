<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Amenity extends Model
{
    protected $table = 'amenities';
    protected $fillable = [
        'name',
        'slug',
    ];


    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class,'post_amenities');
    }
}
