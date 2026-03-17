<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostImage extends Model
{
    protected $table = 'post_images';
    protected $fillable = [
        'post_id',
        'image',
        'sort_order',
        'is_thumbnail',
    ];

    //belongTo
    public function post() : BelongsTo{
        return $this->belongsTo(Post::class,'post_id', 'id');
    }
}
