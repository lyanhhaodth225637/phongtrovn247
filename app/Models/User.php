<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
    
    use HasFactory, Notifiable, HasRoles;
   

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'status',
        'email',
        'password',
        'referred_by',
        'balance',
        'has_deposited',

    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {

        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function userMemberships(): HasMany
    {
        return $this->hasMany(UserMembership::class, 'user_id', 'id');
    }


    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

}
