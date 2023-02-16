<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use PDO;

use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::Filter()->get();
        $categories = Categories::all();
        // dd($products);
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        return view('products', $data);
    }
    public function getProducts(Request $request){
        $products = Product::Filter()->paginate(8);
        // dd($product  s);
        foreach ($products as $p) {
            $p->newPrice = $p->newPrice();
            $p->wish = count($p->getWishes()) > 0 ? true : false;
        } 
        return response()->json([
            'products' => $products
        ]);
    }
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        
        $product->newPrice = $product->newPrice();
        
        $product->wish = count($product->getWishes()) > 0 ? true : false;
        $suggest = Product::where("cat_id", $product->cat_id)->where('id' , '!=' , $product->id)->paginate(10);
        foreach ($suggest as $s) {
            $s->newPrice = $s->newPrice();
            $s->wish = count($s->getWishes()) > 0 ? true : false;
        }
        $comments = Comment::where('pro_id' , $product->id)->where('type' , 'product')->get();
        $data = [
            'product' => $product,
            "suggest" => $suggest,
            'comments' => $comments
        ];
        return view('product', $data);
    }
    public function getProduct(Request $request)
    {
        $id = $request->id;
        $product = Product::where('id', $id)->first();
        $product->newPrice = $product->newPrice();
        $product->wish = count($product->getWishes()) > 0 ? true : false;
        $product->rate = $product->rate();
        if ($product != null) {
            return response()->json([
                "status" => 'success',
                "product" => $product
            ]);
        } else {
            return response()->json([
                "status" => 'error'
            ]);
        }
    }
    public function addCart(Product $product, Request $request)
    {
        if (auth()->user() != null) {
            $cart = Cart::where("user_id", auth()->user()->id)->where('pro_id', $product->id)->where('size' , $request->size)->first();
            if ($cart == null) {
                Cart::create([
                    "pro_id" => $product->id,
                    "user_id" => auth()->user()->id,
                    "size" => $request->size,
                    "number" => $request->number
                ]);
            }else{
                $cart->update([
                    "number" => $cart->number + $request->number
                ]);
            }
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'login'
            ]);
        }
    }
    public function addWish(Product $product)
    {
        if (auth()->user() != null) {
            $wishList = auth()->user()->wishlist;
            if (in_array($product->id, auth()->user()->wishlist)) {
                $wishes = [];
                foreach (auth()->user()->wishlist as $wish) {
                    array_push($wishes, $wish);
                }
                $wishes = array_diff($wishes, array($product->id));
                $wishList = [];
                foreach ($wishes as $w) {
                    array_push($wishList, $w);
                }
                auth()->user()->update([
                    "wishlist" => $wishList
                ]);
                return response()->json([
                    "status" => "remove"
                ]);
            } else {
                array_push($wishList, $product->id);
                auth()->user()->update([
                    "wishlist" => $wishList
                ]);
                return response()->json([
                    "status" => "add"
                ]);
            }
        } else
            return response()->json([
                "status" => 'login'
            ]);
    }
    public function getSizes(Request $request)
    {
        $sizes = Product::where('id', $request->id)->first()->sizes;
        return response()->json([
            "sizes" => $sizes,
        ]);
    }
    public function sendRate(Request $request){
        if(auth()->user() != null){
            
            if($request->body != '' && strlen($request->body) < 250 && $request->rate != 0){
            $comments =  Comment::create([
                    'pro_id' => $request->pro_id,
                    'user_id' => auth()->user()->id,
                    'rate' => $request->rate,
                    'body' => $request->body,
                    'type' => $request->type
            ]);
            $comments->user = $comments->user->id;
                return response()->json([
                    'status' => 'success',
                    'comment' => $comments
                ]);
            }else{
                return response()->json([
                    'status' => 'error'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'login'
            ]);
        }
    }
    public function searchProduct(Request $request){
        $products = Product::where('name' , 'like' , '%'.$request->search.'%')->paginate(8);
        foreach($products as $p){
            $p->newPrice = $p->newPrice();
            $p->rate = $p->rate();
            $p->wish = count($p->getWishes()) > 0 ? true : false;
        }
        return response()->json([
            'products' => $products
        ]);
    }
    public function cartShow(){
        if(auth()->user() != null){
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
                $product->subTotal = ($newPrice*$c->number);
                array_push($products, $product);
            }
            $data = [
                "products" => $products,
                "subTotal" =>$subTotal
            ];
            return view('cart' , $data);
        }else{
            return redirect('login');
        }
    }
    public function wishlist(){
        if(auth()->user() != null){
            $products = [];
            foreach(auth()->user()->wishlist as $p){
                $product = Product::where('id' , $p)->first();
                array_push($products , $product);
            }
            return view('wishlist' , compact('products'));
        }else{
            return redirect('/login');
        }
    }
}
