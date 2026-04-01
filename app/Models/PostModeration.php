<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PostModeration extends Model
{
    protected $table = 'post_moderations';

    protected $fillable = [
        'post_id',
        'action',
        'reason_type',
        'reason_detail',
        'user_id',
    ];

    // Quan hệ với Post
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id', 'id');
    }

    // Quan hệ với Admin (User)
    public function admin() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}