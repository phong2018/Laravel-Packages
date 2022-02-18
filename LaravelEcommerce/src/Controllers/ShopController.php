<?php

namespace Phonglg\LaravelEcommerce\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelEcommerce\Models\Product;
use Illuminate\Support\Str; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShopController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    { 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $products=Product::all();
        $cart= Cart::content();
        // dd($cart);
        return view('laravelecommerce::shops.index',['products'=>$products,'cart'=>$cart]);
    }
}