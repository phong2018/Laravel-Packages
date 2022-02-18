<?php

namespace Phonglg\LaravelEcommerce\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelEcommerce\Models\Product;
use Illuminate\Support\Str; 
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Product::class, 'product');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate(10);
        return view('laravelecommerce::products.index', ['products' => $products]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::all();
        return view('laravelecommerce::products.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|max:256',
            'description'=>'required',
            'price'=>'required|numeric|min:0',
            'image'=>'required|max:256'
            // 'image'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); 

        // if(!empty($request->image)){
        //     $path ='images/products/';
        //     $file = time().'-'.$request->image->getClientOriginalName();  
        //     $request->image->move(public_path($path), $file);     
        //     $image=$path.$file;
        // }else $image='';

        $fields=array(
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
            'description'=>$request->description,
            'price'=>$request->price,
            'image'=>$request->image
        );
    
        $product=Product::create($fields); 
 
        $product->categories()->attach(Category::find($request->categories));
        
        return redirect()->route('products.index')->with('message','Produt create success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        // dd($product->categories);

        $categories=Category::all();
        return view('laravelecommerce::products.edit',['product'=>$product,'categories'=>$categories]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // 
        
        $request->validate([
            'name'=>'required|max:256',
            'description'=>'required',
            'price'=>'required|numeric|min:0',
            'image'=>'required|max:256'
            // 'image'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); 
        
        // $image=$product->image; 
        // if(!empty($request->image)){
        //     $oldimage=public_path().'/'.$product->image;
        //     if($product->image && file_exists($oldimage)) unlink($oldimage);

        //     $path ='images/products/'; 
        //     $file = time().'-'.$request->image->getClientOriginalName();  
        //     $request->image->move(public_path($path), $file); 
        //     $image=$path.$file;
        // }  

        $fields=array(
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'image'=>$request->image
        );
        $product->update($fields);

        $product->categories()->detach();
        $product->categories()->attach(Category::find($request->categories));
        
        

        return redirect()->route('products.index')->with('message','Product update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return back();
    } 
}