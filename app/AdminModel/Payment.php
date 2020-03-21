<?php

namespace App\AdminModel;

use App\User;
use App\AdminModel\Discount;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discount(){
        return $this->hasOne(Discount::class);
    }

    public function getModeAttribute($value)
    {
        $value = (strpos($value,'-')!==false)? str_replace('-',' ',$value):$value;
        return ucwords($value);
    }

}
