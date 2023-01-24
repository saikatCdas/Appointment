<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'fromTime', 'toTime','status', 'maxApplicant', 'next_meeting_time'];

    public function user (){
        return $this->belongsTo(User::class);
    }
}
