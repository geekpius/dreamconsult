<?php

namespace App\AdminModel;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment(){
        return $this->belongsTo(User::class, 'payment_id');
    }

}
