<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use PDO;

use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $cat = $request->cat;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $sort = $request->sort;

        $products = Product::latest();
        if (isset($cat)) {
            if ($cat != 'all') $products->where('cat_id', intval($cat));
        }
        if (isset($minPrice) && isset($maxPrice)) {
            $products->where('price', '>=', $minPrice)->where('price', '<=', $maxPrice);
        }
        if (isset($sort)) {
            if ($sort == 'newest') $products->orderBy('id', 'desc');
            if ($sort == 'cheep') $products->orderBy('price');
            if ($sort == 'expensive') $products->orderBy('price', 'desc');
            if ($sort == 'off') $products->orderBy('off', 'desc');
        } else {
            $products->orderBy('id', 'desc');
        }
        $products = $products->get();
        $categories = Categories::all();
        foreach ($products as $p) {
            if ($p->off != 0) {
                $off = $p->off;
                $newPrice = ($p->price) * (100 - $off) / 100;
            } else {
                $newPrice = $p->price;
            }
            $p->newPrice = $newPrice;
            if (auth()->user() != null) {
                $userWishList = User::where('id', auth()->user()->id)->where('wishlist', 'like', '%' . ',' . $p->id . ',' . '%')
                    ->orwhere('wishlist', 'like', '%' . ',' . $p->id . ']' . '%')
                    ->orwhere('wishlist', 'like', '%' . '[' . $p->id . ',' . '%')
                    ->orwhere('wishlist', 'like', '%' . '[' . $p->id . ']' . '%')->get();
            } else {
                $userWishList = [];
            }
            $p->wish = count($userWishList) > 0 ? true : false;
        }
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        return view('products', $data);
    }
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product->off != 0) {
            $off = $product->off;
            $newPrice = ($product->price) * (100 - $off) / 100;
        } else {
            $newPrice = $product->price;
        }
        $product->newPrice = $newPrice;
        if (auth()->user() != null) {
            $productWish = User::where('id', auth()->user()->id)->where('wishlist', 'like', '%' . ',' . $product->id . ',' . '%')
                ->orwhere('wishlist', 'like', '%' . ',' . $product->id . ']' . '%')
                ->orwhere('wishlist', 'like', '%' . '[' . $product->id . ',' . '%')
                ->orwhere('wishlist', 'like', '%' . '[' . $product->id . ']' . '%')->get();
        } else {
            $productWish = [];
        }
        $product->wish = count($productWish) > 0 ? true : false;
        $suggest = Product::where("cat_id", $product->cat_id)->paginate(10);
        foreach ($suggest as $s) {
            if ($s->off != 0) {
                $s_off = $s->off;
                $s_newPrice = ($s->price) * (100 - $s_off) / 100;
            } else {
                $s_newPrice = $s->price;
            }
            $s->newPrice = $s_newPrice;
            if (auth()->user() != null) {
                $userWishList = User::where('id', auth()->user()->id)->where('wishlist', 'like', '%' . ',' . $s->id . ',' . '%')
                    ->orwhere('wishlist', 'like', '%' . ',' . $s->id . ']' . '%')
                    ->orwhere('wishlist', 'like', '%' . '[' . $s->id . ',' . '%')
                    ->orwhere('wishlist', 'like', '%' . '[' . $s->id . ']' . '%')->get();
            } else {
                $userWishList = [];
            }
            $s->wish = count($userWishList) > 0 ? true : false;
        }
        $data = [
            'product' => $product,
            "suggest" => $suggest
        ];
        return view('product', $data);
    }
    public function getProduct(Request $request)
    {
        $id = $request->id;
        $product = Product::where('id', $id)->first();
        if ($product->off != 0) {
            $off = $product->off;
            $newPrice = ($product->price) * (100 - $off) / 100;
        } else {
            $newPrice = $product->price;
        }
        $product->newPrice = $newPrice;
        if (auth()->user() != null) {
            $productWish = User::where('id', auth()->user()->id)->where('wishlist', 'like', '%' . ',' . $product->id . ',' . '%')
                ->orwhere('wishlist', 'like', '%' . ',' . $product->id . ']' . '%')
                ->orwhere('wishlist', 'like', '%' . '[' . $product->id . ',' . '%')
                ->orwhere('wishlist', 'like', '%' . '[' . $product->id . ']' . '%')->get();
        } else {
            $productWish = [];
        }
        $product->wish = count($productWish) > 0 ? true : false;
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
                $wishList = array_diff($wishList, array($product->id));
                $wishList2 = [];
                foreach ($wishList as $w) {
                    array_push($wishList2, $w);
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
}
