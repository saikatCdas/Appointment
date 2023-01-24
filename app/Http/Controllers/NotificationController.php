<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $notifications = auth()->user()->notifications()->paginate(20);

        return $notifications;
    }

    public function unreadNotifications(){
        $notifications = auth()->user()->unreadNotifications;

        return $notifications;
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['link']);
        }
    }
    public function markAllAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
    }
}
