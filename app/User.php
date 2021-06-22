<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nit'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y', 
    ];

    /**
     * Get all activities for the user.
     */
     public function activities()
     {
         return $this->hasMany('App\Models\Activity');
     }

     /**
     * Get all of the posts for the country.
     */
    public function reports()
    {
        return $this->hasManyThrough('App\Models\ActivityReport', 'App\Models\Activity');
    }

}
