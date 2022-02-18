<?php

namespace Phonglg\LaravelVeso\Jobs;

use Illuminate\Bus\Queueable; 
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelVeso\Events\PaidOrderSuccess;
use Phonglg\LaravelVeso\Services\OrderServices;

class PointJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $message;

    public function __construct($message)
    {
        // 
        $this->message=$message;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    { 
        Log::debug('handle run PointJob');
        Log::debug($this->message);

        if($this->message['typeJob']==config('laravelveso.pointJobType.PaidOrderSuccess.key')){ 
            $usersLockPoint=(new OrderServices())->getUsersLockPoint($this->message['orderId']);

            if($usersLockPoint[0]==0) event(new PaidOrderSuccess($this->message['orderId'],false));

            else throw ValidationException::withMessages(['message' => 'Job fail']); 
        }
    }
}
