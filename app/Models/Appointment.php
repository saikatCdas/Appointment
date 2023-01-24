<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'student_id', 'date' , 'description', 'status', 'meeting_time'];

    public function users(){
        return $this->belongsToMany(User::class, 'user_appointments');
    }
}
