<div class="overflow-x-scroll">
    
    <table class="table">
        <tr>
            <th>Image</th>
            <th>Name</th> 
            <th>Price</th> 
            <th>Update Quantity</th> 
            <th>Remove</th>
        </tr> 
        @foreach ($cart as $rowId=>$product)
        <tr>
            <td>
            <img src="{{ url($product->options['image']) }}" alt="" class="w-10 ">
            </td>
            <td>{{ $product->name }}</td> 
            <td>${{ $product->price }}</td> 
            <td>
                <form action="{{route('cart.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{$rowId}}" name="rowId"> 
                    <input type="number" value="{{$product->qty}}" name="qty" class='border w-16' > 
                    <button class="px-4 py-2 text-white bg-blue-800 rounded">Update</button>
                </form> 
            </td>
            <td> 
                <form action="{{route('cart.delete')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("DELETE")
                    <input type="hidden" value="{{$rowId}}" name="rowId"> 
                    <button class="px-4 py-2 text-white bg-red-800 rounded">Remove</button>
                </form> 
            </td>
        </tr>
        @endforeach
    </table> 
</div> 