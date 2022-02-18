<?php
namespace Phonglg\LaravelNotifications\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;  
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelNotifications\Notifications\SendNotificationsViaDatabase;
use Phonglg\LaravelNotifications\Notifications\SendNotificationsViaEmail;

class CallNoitification extends Controller
{
    // SendNotificationsViaEmail
    public function SendNotificationsViaEmail(){
        $user=User::first();
        $message=[
            'body'=>'You receive Notification From Laravel',
            'enrollmentText'=>'you are allow enroll',
            'url'=>url('/'),
            'thankyou'=>'Thank you',
        ];

        $user->notify(new SendNotificationsViaEmail($message));
        // or use
        // Notification::send($user, new SendNotificationsViaEmail($message));
        
    }

    // SendNotificationsViaDatabase
    public function SendNotificationsViaDatabase(){
        $admin=User::first();
        $message=[
            'body'=>'You receive Notification ViaDatabase',
            'enrollmentText'=>'you are allow enroll',
            'url'=>url('/'),
            'thankyou'=>'Thank you',
        ];

        $user=User::find(7);

        Notification::send($admin, new SendNotificationsViaDatabase($user,$message)); 
    }

    // getNotificationsFromDatabase
    public function getNotificationsFromDatabase(){
        $admin=User::first();
        $notificationData=$admin->notifications;
        dd($notificationData);
    }
}
