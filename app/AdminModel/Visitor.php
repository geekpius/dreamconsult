<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //


    public function getFirstNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucwords($value);
    }




}