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
    public function home(){
        $products = Product::all();
        return view('main',["products"=>$products]);
    }
}
