<?php

namespace App;

use Carbon\Carbon;
use App\AdminModel\Payment;
use App\AdminModel\Profile;
use App\AdminModel\Service;
use App\AdminModel\Discount;
use App\AdminModel\Emergency;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function profile(){
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function emergency(){
        return $this->hasOne(Emergency::class, 'user_id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function service(){
        return $this->hasMany(Service::class, 'user_id');
    }

    public function discounts(){
        return $this->hasMany(Discount::class, 'user_id');
    }

    public function getDobAttribute()
    {
        return (empty($this->profile->dob))? '':Carbon::parse($this->profile->dob)->format('d M, Y');
    }

    public function getAgeAttribute()
    {
        return (empty($this->profile->dob))? '':Carbon::parse($this->profile->dob)->age;
    }
}
