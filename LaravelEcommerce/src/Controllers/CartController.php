<?php

namespace Phonglg\LaravelEcommerce\Controllers;
use Phonglg\LaravelEcommerce\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{ 
    // show carts
    public function index()
    {
        // dd('cart.index');
        $cart= Cart::content();
        //dd($cart);
        return view('laravelecommerce::cart.index',['cart'=>$cart]);
    }

    // checkout carts
    public function checkout()
    {
        // dd('cart.index');
        $cart= Cart::content(); 
        return view('laravelecommerce::cart.checkout',['cart'=>$cart]);
    }

    // store product to cart
    public function store(Product $product){ 
        // dd($product->id,$product->name,$product->price); 
        Cart::add(['id' => $product->id, 'name' => $product->name, 'qty' => 1, 'price' => $product->price, 'weight' => 550, 'options' => ['image'=>$product->image,'size' => 'large']]);
        return redirect()->back()->with('message','Add products success');
    }

    // update product in cart
    public function update(Request $request) { 
        Cart::update($request->rowId,$request->qty);
        return redirect()->back()->with('message','Update products success');
    }

    // remove product from carts
    public function delete(Request $request) { 
        //dd('delete',$request,$request->rowId);
        Cart::remove($request->rowId);
        return redirect()->back()->with('message','Remove products success');
    }
     
}