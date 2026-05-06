<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
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
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('membership')
            ->logOnly([
                'name',
                'slug',
                'priority',
                'color',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, "membership_id", 'id');
    }

    public function membershipPackages(): HasMany
    {
        return $this->hasMany(MembershipPackage::class, 'membership_id');
    }


}