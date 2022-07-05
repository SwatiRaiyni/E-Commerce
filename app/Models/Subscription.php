<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    public $table="subscription";

    // public static function userdata(){
    //     return $this->has('App\Models\User','id')->select('id','name','email','phone');
    // }
}
