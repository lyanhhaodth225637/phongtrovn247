<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
    ];

    public function locations() : HasMany
    {
        return $this->hasMany(Location::class,'category_id', 'id');
        //1 category → nhiều location
    }

    public function posts() : HasMany{
    return $this->hasMany(Post::class,'category_id', 'id');
    }
}
