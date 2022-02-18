<?php

namespace Phonglg\LaravelEcommerce\Controllers;
use Phonglg\LaravelEcommerce\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Phonglg\LaravelEcommerce\Models\Order;
use Phonglg\LaravelEcommerce\Models\OrderProduct;

class OrderController extends Controller
{  
    // checkout carts
    public function checkout()
    {
        // dd('cart.index');
        $cart= Cart::content(); 
        return view('laravelecommerce::order.checkout',['cart'=>$cart]);
    }

    // store order
    public function store(Request $request){ 
        $this->validateOrder($request);
    
        $fields=array(
            'status'=>'pendding',
            'currency'=> '$',
            'total'=>1000, 
        );
        $order=Order::create($fields); 

        $this->insertOrderProducts($order);
        return redirect()->route('order.success')->with('message','Orders success');
    } 

    // insertOrderProducts
    public function insertOrderProducts($order){
        $cart= Cart::content();   
        $orderProducts = []; 
        foreach ($cart as $rowId=>$product) {
            $orderProducts[] = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $product->qty
            ];
        }
        OrderProduct::insert($orderProducts);
        Cart::destroy();
    }
    // checkout succes
    public function success()
    {
        return view('laravelecommerce::order.success');
    }

    // validateOrder
    public function validateOrder($request){
        $request->validate([
            'fullname'=>'required|min:5|max:256', 
            'address'=>'required|min:5|max:256'
        ]);
    }

     
}