<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserNotification extends Notification
{
    use Queueable;

    public $user;
    public $message;
    public $path;

    public function __construct($user, $message, $path)
    {
        $this->user = $user;
        $this->message = $message;
        $this->path = $path;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' =>$this->user['id'],
            'name' => $this->user['name'],
            'image_url' =>  $this->user['image'] ?  URL::to($this->user['image']): null,
            'department' => $this->user['department'],
            'message' => $this->message,
            'path' => $this->path,
        ];
    }
}
