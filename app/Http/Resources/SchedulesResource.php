<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class SchedulesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'user_id' => $this->user_id,
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'status' => $this->status,
            'fromTime' => $this->fromTime,
            'toTime' => $this->toTime,
            'maxApplicant' => $this->maxApplicant,
            'next_meeting_time' => $this->next_meeting_time,
        ];
    }
}
