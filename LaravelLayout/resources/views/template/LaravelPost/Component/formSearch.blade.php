<form action="{{route('search')}}" method='GET'>
<input type="text" value="@yield('title')" placeholder="Search" name='title' class='border text-sm md:float-right p-1 float-left' />
</form>