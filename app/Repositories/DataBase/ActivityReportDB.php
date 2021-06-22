<?php

namespace App\Repositories\DataBase;

use App\Models\ActivityReport;

class ActivityReportDB
{
    public function create($request){
        $activityReport = ActivityReport::create([
            'activity_id'       => $request->activity_id,
            'report_date'       => $request->report_date,
            'reported_hours'    => $request->reported_hours,
        ]);
        return $activityReport;    
    }
}