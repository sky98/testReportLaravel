<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'user_id', 'description' 
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'created_at' => \App\Models\Casts\DateFormat::class,
    ];

     /**
     * Get all report for the activity.
     */
     public function reports()
     {
         return $this->hasMany('App\Models\ActivityReport');
     }

     /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
