<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Categories;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $products = Product::all();
        return view('main', ["products" => $products]);
    }
    public function getCart()
    {
        if (auth()->user() != null) {
            $subTotal = 0;
            $cart = Cart::where('user_id', auth()->user()->id)->get();
            $products = [];
            foreach ($cart as $c) {
                $product = Product::where('id', $c->pro_id)->first();
                $newPrice = $product->newPrice();
                $subTotal = $subTotal + ($newPrice*$c->number);
                $product->cart_id = $c->id;
                $product->newPrice = $newPrice;
                $product->number = $c->number;
                $product->size = $c->size;
                array_push($products, $product);
            }
            
            return response()->json([
                "status" => 'success',
                "products" => $products,
                "subTotal" =>$subTotal
            ]);
        } else {
            return response()->json([
                'status' => 'login'
            ]);
        }
    }
    public function deleteCart(Request $request){
        $cart = Cart::where('id' , $request->id)->where('user_id' , auth()->user()->id)->first();
        if($cart != null){
            $cart->delete();
            return response()->json([
                'status' => 'success'
            ]);
        }
    }
    public function getCategories(){
        $cat = Categories::all();
        return response()->json([
            'categories' => $cat
        ]);
    }
    
}
