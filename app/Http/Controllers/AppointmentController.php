<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserNotification;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
    *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try{
            $appointments = Appointment::all();

            foreach ($appointments as $appointment) {
                $appointment['applicant'] = new UserResource(User::find($appointment['student_id']));
            }


            return response([
                'appointments' => $appointments
            ]);
        } catch(Throwable $e){
            report( $e);
            return false;
        }
    }

    public function todayAppointment()
    {
        try{
            $appointments = Appointment::latest()->where('status', 'Active')->where('date', Carbon::today())->where(function ($query) {
                $query->where('teacher_id', auth()->id())
                      ->orWhere('student_id', auth()->id());
            })->paginate(10);
            // return ;

            if((auth()->user()->role === 'Teacher' )|| (auth()->user()->role === 'Admin'))
            {
                foreach ($appointments as $appointment) {
                    $appointment['applicant'] = new UserResource(User::find($appointment['student_id']));
                }
            } else{
                foreach ($appointments as $appointment) {
                    $appointment['host'] = new UserResource(User::find($appointment['teacher_id']));
                }
            }


            return response([
                'appointments' => $appointments
            ]);
        } catch(Throwable $e){
            report( $e);
            return $e;
        }
    }

    public function upcomingAppointment()
    {
        try{
            $appointments = Appointment::latest()->where('status', 'Active')->where('date', '>', Carbon::today())->where(function ($query) {
                $query->where('teacher_id', auth()->id())
                      ->orWhere('student_id', auth()->id());
            })->paginate(10);
            // return ;

            if((auth()->user()->role === 'Teacher' )|| (auth()->user()->role === 'Admin'))
            {
                foreach ($appointments as $appointment) {
                    $appointment['applicant'] = new UserResource(User::find($appointment['student_id']));
                }
            } else{
                foreach ($appointments as $appointment) {
                    $appointment['host'] = new UserResource(User::find($appointment['teacher_id']));
                }
            }


            return response([
                'appointments' => $appointments
            ]);
        } catch(Throwable $e){
            report( $e);
            return $e;
        }
    }


    public function newAppointment()
    {
        try{
            $appointments = Appointment::latest()->where('status', null)->where(function ($query) {
                $query->where('teacher_id', auth()->id())
                      ->orWhere('student_id', auth()->id());
            })->paginate(10);

            if((auth()->user()->role === 'Teacher' )|| (auth()->user()->role === 'Admin'))
            {
                foreach ($appointments as $appointment) {
                    $appointment['applicant'] = new UserResource(User::find($appointment['student_id']));
                }
            } else{
                foreach ($appointments as $appointment) {
                    $appointment['host'] = new UserResource(User::find($appointment['teacher_id']));
                }
            }


            return response([
                'appointments' => $appointments
            ]);
        } catch(Throwable $e){
            report( $e);
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request['student_id'] = auth()->id();
            $data = $request->validate([
                'student_id' => 'required|integer',
                'teacher_id' => 'required|integer',
                'date' => 'required|date',
                'description' => 'required|string',
                'meeting_time' => 'required|string'
            ]);

            $appointment = Appointment::create($data);

            $usersId = [$data['student_id'], $data['teacher_id']];
            $appointment->users()->attach($usersId);

            $teacher = User::find($data['teacher_id']);
            $student = User::find($data['student_id']);
            $message = 'Requested for an appointment';
            $path = "/request-for-appointment/{$appointment->id}";

            $teacher->notify(new UserNotification($student, $message, $path));
            return 'success';
        }catch(Throwable $e){
            report($e);
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);

        $appointment['applicant'] = new UserResource(User::find($appointment['student_id']));

        return response([
            'appointment' => $appointment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $appointment = Appointment::whereId($request->id)->first();
            $schedule = Schedule::get()->where('user_id', auth()->id())->where('date', '=', $request->date)->first();

            $time = new Carbon($schedule->next_meeting_time);
            $meetingTime = $time->addMinutes(30)->format('H:i');

            $appointment['status'] = 'Active';
            $appointment['meeting_time'] = $meetingTime;
            $schedule['next_meeting_time'] = $meetingTime;

            $appointment->save();
            $schedule->save();
            return 'success';
        }catch(Throwable $e){
            report($e);

            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $teacher = User::find($appointment['teacher_id']);
        $student = User::find($appointment['student_id']);
        $message = 'Your appointment has been deleted';
        $path = "";


        if($appointment->teacher_id == auth()->id() || $appointment->student_id == auth()->id() || auth()->user()->role == 'Admin') {
            $student->notify(new UserNotification($teacher, $message, $path));
            $appointment->delete();
            return response(['success'], 200);
        }
        return abort(403, 'Unauthorized Action');
    }
}
