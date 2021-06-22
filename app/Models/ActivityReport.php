<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'activity_id', 'report_date', 'reported_hours'
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
     * Get the user that owns the activity.
     */
     public function activity()
     {
         return $this->belongsTo('App\Models\Activity');
     }

}
