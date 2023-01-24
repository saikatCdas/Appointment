<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'position' => $this->position,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'department' => $this->department,
            'course' => $this->course,
            'about' => $this->about,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'joining_date' => $this->joining_date,
            'mobile' => $this->mobile,
            'languages' => $this->languages,
            'schedules' => SchedulesResource::collection($this->schedules->where('date', '>' , Carbon::now()->format('Y-m-d'))),
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s')
        ];
    }
}
