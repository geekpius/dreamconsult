<?php

namespace App\AdminModel;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    

    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
