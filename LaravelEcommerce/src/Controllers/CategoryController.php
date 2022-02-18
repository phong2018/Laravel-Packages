<?php

namespace Phonglg\LaravelEcommerce\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelEcommerce\Models\Product;
use Illuminate\Support\Str; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Category::class, 'category');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('laravelecommerce::categories.index', ['categories' => $categories]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('laravelecommerce::categories.create');
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
            'description'=>'required'
        ]); 

        $fields=array(
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
            'description'=>$request->description
        );
    
        Category::create($fields);
        
        return redirect()->route('categories.index')->with('message','Category create success');

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
    public function edit(Category $category)
    {
        //
        return view('laravelecommerce::categories.edit',['category'=>$category]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // 
        $request->validate([
            'name'=>'required|max:256',
            'description'=>'required', 
        ]);  

        $fields=array(
            'name'=>$request->name,
            'description'=>$request->description 
        );
        $category->update($fields);
        
        return redirect()->route('categories.index')->with('message','Category update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return back();
    } 
}