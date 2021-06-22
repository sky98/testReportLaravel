<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\ActivityReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ActivityReportResource as ReportResource;
use App\Http\Requests\ActivityReportStoreRequest as ReportRequest;
use App\Repositories\DataBase\ActivityReportDB as DataBaseReport;

class ActivityReportController extends Controller
{

    protected $dataBaseReport;

    public function __construct(DataBaseReport $dataBaseReport) {
        $this->dataBaseReport = $dataBaseReport;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug("User with ID = ".Auth::User()->id." and Nit = ".Auth::User()->nit.", entering the index method of the ActivityReportController");
        $reports = Auth::User()->reports()->get();
        return ReportResource::collection($reports);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getReportsForActivity(Activity $activity)
     {
         Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the getReportsForActivity method of the ActivityReportController");
         $reports = $activity->reports()->get();
         if(empty($reports))
            return response()->json([
                'status'        => 'success',
                'response_code' =>  200,
                'data'          =>  null,
                'message'       =>  'Resource not found',
            ],200);
         return ReportResource::collection($reports);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the store method of the ActivityReportController");
        $report = $this->dataBaseReport->create($request);
        Log::debug("successfully created report ".$report);
        return ReportResource::make($report);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivityReport  $activityReport
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityReport $activityReport)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the show method of the ActivityReportController");
        if($activityReport->exists)
            return ReportResource::make($activityReport);
        return response()->json([
            'status'        => 'error',
            'response_code' =>  404,
            'data'          =>  null,
            'message'       =>  'Resource not found',
        ],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityReport  $activityReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityReport $report)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the update method of the ActivityReportController");
        $report->update($request->all());
        Log::debug("successfully updated report ".$report);
        return ReportResource::make($report);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivityReport  $activityReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityReport $activityReport)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the destroy method of the ActivityReportController");
        Log::debug("successfully destroyed report ".$activityReport);
        $activityReport->delete();
        $reports = Auth::User()->reports()->get();
        return ReportResource::collection($reports);
    }
}
