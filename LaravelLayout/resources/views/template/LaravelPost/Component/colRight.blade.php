
 <!-- calendar hidden md:inline-block -->
<div class='datePicker'>
@include('laravellayout::components.calendar')
</div>

<!-- module 100 so -->
<div class='w-full hidden' >
    <h3 class='tiltle100So'>Ý nghĩa 100 con số?</h3>
    <div class='scroll100So'>
    <img class='w-full' src="{{asset('storage/photos/1/Default/100SO.png')}}" alt=""> 
    </div>
</div>
<style>
    .tiltle100So{
        margin-top: 7px;
        background-color: #d0d0d0;
        padding:10px;
        font-weight: bold;
    }
    .scroll100So{
        overflow: scroll;
        height: 439px;
        width: 100%;
        border: 1px solid #d0d0d0;
    }
    /* width */
    ::-webkit-scrollbar {
    width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    background: #f1f1f1; 
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: #888; 
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: #555; 
    }
</style>