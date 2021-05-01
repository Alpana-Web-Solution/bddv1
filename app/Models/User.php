<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Requisition;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'blood_group',
        'is_donor',
        'last_donated',
        'pincode_id',
        'mobile',
        'other_contact',
        'donor_id',
        'can_not_donate_until',
        'avatar',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'can_not_donate_until'=>'datetime',
        'last_donated'=>'datetime',
    ];

    public function donations()
    {
        return $this->hasMany('App\Models\Donation','user_id','id');
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
    
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

}
