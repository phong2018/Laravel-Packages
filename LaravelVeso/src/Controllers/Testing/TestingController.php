<?php

namespace Phonglg\LaravelVeso\Controllers\Testing;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail; 
use Illuminate\Support\Facades\Gate;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelVeso\Events\PrintTicketSuccess;
use Phonglg\LaravelVeso\Helpers\TestingHelpers;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class TestingController extends Controller
{   
    // http://127.0.0.1/testAll
    public function testAll(){ 
        TestingHelpers::test_vethuongPrize();
        TestingHelpers::test_mega645Prize();
        
    }
 
}