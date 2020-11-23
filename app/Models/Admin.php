<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//changed part
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//end
class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable=[
        'name','email','password',
    ];

    protected $hidden=[
        'password','remember_token',
    ];

    protected $casts=[
        'email_verified_at'=>'date_time',
    ];

}
