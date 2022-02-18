<?php

namespace Phonglg\LaravelQueues\Jobs;

use Illuminate\Bus\Queueable; 
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; 
use Phonglg\LaravelQueues\Mail\WelcomeMail;

class SendEmailUsingQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;

    public function __construct(User $user )
    {
        //
        $this->user=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Test if have JOB?');
        //Mail::to($this->user->email)->send(new WelcomeMail('Demo Using Queue to send Email in Job'));
    }
}
