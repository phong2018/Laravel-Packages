<?php 

namespace  Phonglg\LaravelQueues\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels; 

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $welcomeMessage;

    public function __construct($welcomeMessage)
    {
        $this->welcomeMessage = $welcomeMessage;
    }

    public function build()
    {
        return $this->view('laravelqueues::emails.welcome');
    }
}