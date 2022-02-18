<?php

namespace Phonglg\LaravelNotifications\Notifications;

use Illuminate\Bus\Queueable; 
use Illuminate\Notifications\Notification;

class SendNotificationsViaDatabase extends Notification
{
    use Queueable;
    private $user;
    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$message='')
    {
        //
        $this->user=$user;
        $this->message=$message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
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
            //
            'name'=>$this->user->name,
            'email'=>$this->user->email,
            'message'=>$this->message
        ];
    }
}
