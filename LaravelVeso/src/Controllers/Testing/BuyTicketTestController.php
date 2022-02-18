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
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class BuyTicketTestController extends Controller
{   
    // http://localhost/testBuyTicket
    public function buyTicket(){ 
        event(new PrintTicketSuccess('3#0#mega'));
        event(new PrintTicketSuccess('4#0#power'));
        event(new PrintTicketSuccess('5#0#max3d'));
        event(new PrintTicketSuccess('6#0#max3d+'));
        event(new PrintTicketSuccess('7#0#3dprobasic'));
        event(new PrintTicketSuccess('8#1#keno'));
        event(new PrintTicketSuccess('9#1#keno'));
    }
}