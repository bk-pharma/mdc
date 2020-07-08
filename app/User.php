<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'auth_users_tbl';
<<<<<<< HEAD
    public $timestamps = false;
    protected $primaryKey = 'auth_id';
=======
>>>>>>> c48581654b53400b8dd44e879daf12707dfb3c56
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
         'auth_usercode', 'username', 'password', 'auth_fullname', 'auth_role'
=======
>>>>>>> c48581654b53400b8dd44e879daf12707dfb3c56
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
