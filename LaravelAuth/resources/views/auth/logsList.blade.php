
@extends($data['template'])

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Lịch sử hoạt động</h1> 

     @if($logs->count()>0)
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>STT</th>
                <th>ID</th>
                <th>Logs</th>  
                <th>User</th>  
                
                <th>Ngày tạo</th>  
            </tr>  
            @foreach($logs as $no=>$log)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td> 
                <td>{{$log->id}}</td> 
                <td>{!!$log->log!!}</td>  
                <td>{{$log->user->name}} ({{$log->user->username}})</td>  
                <td>{{date("d/m/Y H:i:s", strtotime($log->created_at))}}</td>  
             
            </tr>
            @endforeach
        </table> 
        {{ $logs->links() }}
    </div>
    @endif 
</div>

@endsection