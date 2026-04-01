<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipPackage extends Model
{
    protected $table = 'membership_packages';
    protected $fillable = [
        'membership_id',
        'duration_days',
        'price',
        'is_active',
        'description',
    ];


    public function userMemberships(): HasMany
    {
        return $this->hasMany(UserMembership::class, 'membership_package_id', 'id');
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');

    }

}
