<?php

namespace Phonglg\LaravelAuth\Controllers\Auth;

use App\Http\Controllers\Controller;  
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelVeso\Helpers\Vietlott;

use function PHPSTORM_META\type;

class AccountController extends Controller
{ 
    use AuthorizesRequests;

    public function prepareAgencyInfo($agencyInfo){ 
        
        $agencyInfo=(array)json_decode($agencyInfo); 

        if(!isset($agencyInfo['agencyName'])) $agencyInfo['agencyName']='';
        if(!isset($agencyInfo['agencyPhone'])) $agencyInfo['agencyPhone']='';
        if(!isset($agencyInfo['agencyAddress'])) $agencyInfo['agencyAddress']='';
        return $agencyInfo;
    }

    public function customerList(){
        $data['customers']=User::where('presenter_id',9)->paginate(20); 

        $data['template']=Vietlott::getLayoutForUser();

        return view('laravelauth::auth.customerList',['data'=>$data]);    
    }

    public function edit()
    {  
        $user=Auth::user();

        $this->authorize('Account:update',$user);

        $user['agency_info']=$this->prepareAgencyInfo($user['agency_info']);
        $refundTickets=json_decode($user['refund_tickets']);
        // caculate refundTickets
        $data['refundTickets']=[0,0];
        if($refundTickets)
        foreach($refundTickets as $refundTicket){
            $data['refundTickets'][0]+=$refundTicket[1];
            $data['refundTickets'][1]+=$refundTicket[2];
        }
        
        $data['template']=Vietlott::getLayoutForUser(); 
     
        
        return view('laravelauth::auth.editAccount', ['user' => $user,'data'=>$data]);
    }  

    public function update(Request $request)
    { 
        $user=Auth::user();

        $this->authorize('Account:update',$user);

        $this->validate($request, [
            'name' => 'required|max:255', 
            'identity_card_number'=>'max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user['id'],
            'password' => 'confirmed',
            // agency_info
            'agencyName'=>'string|max:255|nullable', 
            'agencyPhone'=>'string|max:255|nullable', 
            'agencyAddress'=>'string|max:255|nullable', 
        ]); 

        // prepare agency_info
        $agency_info=array(
            'agencyName' => $request->agencyName,
            'agencyPhone' => $request->agencyPhone,
            'agencyAddress' => $request->agencyAddress,
        );

        // prepare field
        $fields = [
            'name' => $request->name,
            'agency_name' => $request->agencyName,
            'email' => $request->email,
            'identity_card_number' => $request->identity_card_number,
            'password' => $request->password,
            'old_password' => $request->old_password,
            'bank_info' => $request->bank_info,
            'agency_info' => json_encode($agency_info),
        ]; 
 

        if (!empty($fields['password'])) {
            $fields['password'] = Hash::make($fields['password']);
            
            if (!Hash::check($fields['old_password'], Auth::user()->password)) { 
                throw ValidationException::withMessages(['old_password' => 'MK cũ không đúng!']);
            } 

        } else {
            $fields = Arr::except($fields, array('password'));
        }

        $user->update($fields);

        return redirect()->route('account.edit')->with('message', 'Cập nhật thông tin thành công.');
    }

    public function LogsList(){
        if(Auth::id()==1) $logs=UserLog::with('user')->orderBy('id','DESC')->paginate(20); 
        else $logs=UserLog::with('user')->where('userId',Auth::id())->orderBy('id','DESC')->paginate(20); 

        $data['template']=Vietlott::getLayoutForUser();

        return view('laravelauth::auth.logsList',['logs'=>$logs,'data'=>$data]);      
    }
}