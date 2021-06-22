<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'activity_id'       => $this->activity_id,
            'report_date'       => $this->report_date,
            'reported_hours'    => $this->reported_hours,
            'created_at'        => $this->created_at,
        ];
    }
}
