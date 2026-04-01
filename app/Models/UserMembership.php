<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMembership extends Model
{
    protected $table = 'user_memberships';
    protected $fillable = [
        'user_id',
        'membership_package_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function membershipPackage(): BelongsTo
    {
        return $this->belongsTo(MembershipPackage::class, 'membership_package_id', 'id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
