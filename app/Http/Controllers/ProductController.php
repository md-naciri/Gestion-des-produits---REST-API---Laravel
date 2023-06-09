<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $product = $request->all() + ['user_id'=>$user->id];
        Product::create($product);
        return response()->json([
            'status' => true,
            'product' => $product 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message' => 'This product doesn\'t exist',
            ]);
        }
        return response()->json([
            'status' => true,
            'product' => $product
        ]);
    }



    public function getProductsByCategory($categoryName)
    {
        $category = Category::where('name', $categoryName)->firstOrFail();
        $products = Product::where('category_id', $category->id)->get();
        return response()->json($products);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);
        if(!$user->can('update every product') && $user->id != $product->user_id){
            return response()->json(['message' => "You can't edit this product"]);
        }
        $product->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'category' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if(!$product){
            return response()->json([
                'message' => 'This product doesn\'t exist'
            ]);
        }
        $user = Auth::user();
        if(!$user->can('delete every product') && $user->id != $product->user_id){
            return response()->json(['message' => "You can't delete this product"]);
        }
        Product::destroy($id);
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
