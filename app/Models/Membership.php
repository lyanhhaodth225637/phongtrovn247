<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $table = 'memberships';
    protected $fillable = [
        'name',
        'slug',
        'priority',
        'color',
        'description',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, "membership_id", 'id');
    }

    public function membershipPackages(): HasMany
    {
        return $this->hasMany(MembershipPackage::class, 'membership_id');
    }


}