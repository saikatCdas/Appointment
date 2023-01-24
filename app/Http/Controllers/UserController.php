<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculty = User::latest()->where('status', 'Active')->whereIn('role', ['Admin', 'Teacher'])->paginate(20);
        return UserResource::collection($faculty);
    }


    public function newUsers()
    {
        $newUsers = User::where('status', null)->paginate(20);

        return UserResource::collection($newUsers);
    }

    public function newUsersByDepartment($department)
    {
        $newUsers = User::where('status', null)->where('department', $department)->paginate(20);

        return UserResource::collection($newUsers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return new UserResource($user);
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
        return 'success';
    }

    public function allStudent()
    {
        $student = User::latest()->where('status', 'Active')->where('role', 'Student')->paginate(20);
        return UserResource::collection($student);
    }

    public function getStudentByDepartment($department)
    {
        $student = User::where('status', 'Active')->where('role', 'Student')->where('department', $department)->paginate(20);

        return  UserResource::collection($student);
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

    public function facultyByDepartment($department)
    {
        $faculty = User::where('status', 'Active')->wherein('role', ['Teacher', 'Admin'])->where('department', $department)->paginate(20);

        return  UserResource::collection($faculty);
    }
}
