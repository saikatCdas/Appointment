<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = auth()->user();

        $schedules = $user->schedules()->where('date', '>', Carbon::today())->paginate(20);

        return $schedules;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datetime1 = new Carbon($request->fromDate);
        $datetime2 = new Carbon($request->toDate);
        $interval = $datetime1->diff($datetime2);
        $days = intval($interval->format('%a'));

        for($i = 0; $i<= $days; $i++)
        {
            $date = $datetime1->addDay();

            if(in_array($date->format('l'), $request->offDays))
            {
                $status = 'Unavailable';
            }else {
                $status = 'Available';
            }
            Schedule::create([
                'date' => $date,
                'user_id' => auth()->user()->id,
                'fromTime' => $request->fromTime,
                'toTime' => $request->toTime,
                'maxApplicant' => $request->maxApplicant,
                'next_meeting_time' => $request->fromTime,
                'status' => $status
            ]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
