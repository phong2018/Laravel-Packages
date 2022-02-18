<?php

namespace Phonglg\LaravelVeso\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;

class PaidOrderSuccess
{
    use Dispatchable, SerializesModels;

    public $message;
    public $needCheckLockPoint;

    public function __construct($message,$needCheckLockPoint=true)
    {
        $this->message = $message;
        $this->needCheckLockPoint = $needCheckLockPoint;
    }
}