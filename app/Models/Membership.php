<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'duration',
        'priority',
        'max_posts',
        'is_featured',
        'status'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, "membership_id", 'id');
    }
}