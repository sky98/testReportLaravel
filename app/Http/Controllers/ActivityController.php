<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\ActivityStoreRequest as ActivityRequest;
use App\Repositories\DataBase\ActivityDB as DataBaseActivity;

class ActivityController extends Controller
{
    protected $dataBaseActivity;

    public function __construct(DataBaseActivity $dataBaseActivity) {
        $this->dataBaseActivity = $dataBaseActivity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the index method of the ActivityController");
        $activities = Auth::User()->activities()->get();
        return ActivityResource::collection($activities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the store method of the ActivityController");
        $activity = $this->dataBaseActivity->create($request);
        Log::debug("successfully created activity ".$activity);
        return ActivityResource::make($activity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the show method of the ActivityController");
        if($activity->user_id == Auth::id())
            return ActivityResource::make($activity);
        Log::debug("Resource not found");
        return response()->json([
            'status'        => 'error',
            'response_code' =>  404,
            'data'          =>  null,
            'message'       =>  'Not found',
        ],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the update method of the ActivityController");
        if($activity->user_id == Auth::id()){
            $activity->update($request->all());
            Log::debug("successfully updated activity ".$activity);
            return ActivityResource::make($activity);
        }
        Log::debug("Resource not found");
        return response()->json([
            'status'        => 'error',
            'response_code' =>  404,
            'data'          =>  null,
            'message'       =>  'Not found',
        ],404);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        Log::debug("User with ID = ".Auth::id()." and Nit = ".Auth::User()->nit.", entering the destroy method of the ActivityController");
        if($activity->user_id == Auth::id()){
            Log::debug("successfully destroyed activity ".$activity);
            $activity->delete();
            $activities = Auth::User()->activities()->paginate(5);
            return ActivityResource::collection($activities);
        }
        Log::debug("Resource not found");
        return response()->json([
            'status'        => 'error',
            'response_code' =>  404,
            'data'          =>  null,
            'message'       =>  'Not found',
        ],404);        
    }
}
