<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Models\Appointment;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Public routes
Route::get('/search/{search}', [AuthController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('/users', UserController::class);
Route::get('/faculty-by-department/{department}', [UserController::class, 'facultyByDepartment']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/update-profile', [AuthController::class, 'updateProfile']);
    Route::resource('/schedule', ScheduleController::class);
    Route::resource('/appointment', AppointmentController::class);
    Route::get('/get-notifications', [NotificationController::class, 'index']);
    Route::get('/get-unread-notifications', [NotificationController::class, 'unreadNotifications']);
    Route::get('/mark-all-notification-as-read', [NotificationController::class, 'markAllAsRead']);
    Route::group(['middleware' => ['role_admin']],
    function(){
        Route::delete('/delete-user/{id}', [AuthController::class, 'destroy']);
        Route::get('/all-student', [UserController::class, 'allStudent']);
        Route::get('/student-by-department/{department}', [UserController::class, 'getStudentByDepartment']);
        Route::get('/get-new-users', [UserController::class, 'newUsers']);
        Route::get('//get-new-user-by-department/{department}', [UserController::class, 'newUsersByDepartment']);
        Route::post('accept-user', [AuthController::class, 'acceptUser']);
        Route::get('accept-user/{id}', [AuthController::class, 'acceptUser']);
    });
    Route::get('/get-schedules', [ScheduleController::class, 'index']);
    Route::get('/get-new-appointment', [AppointmentController::class, 'newAppointment']);
    Route::get('/get-todays-appointment', [AppointmentController::class, 'todayAppointment']);
    Route::get('/get-upcoming-appointment', [AppointmentController::class, 'upcomingAppointment']);
});


