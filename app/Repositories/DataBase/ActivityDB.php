<?php

namespace App\Repositories\DataBase;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityDB
{
    public function create($request){
        $activity = Activity::create([
            'user_id'       => Auth::id(),
            'description'   => $request->description,
        ]);
        return $activity;    
    }
}