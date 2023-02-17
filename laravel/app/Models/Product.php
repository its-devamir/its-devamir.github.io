<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    // use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cat_id',
        'sizes',
        'images',
        'slug',
        'about',
        'description',
        'amount',
        'price',
        'off',
        'endOff',
    ];
    protected $casts = [
        'images' => 'array',
        'sizes' => 'array'
    ];
    public function newPrice(){
        if ($this->off != 0) {
            $off = $this->off;
            $newPrice = ($this->price) * (100 - $off) / 100;
        } else {
            $newPrice = $this->price;
        }
        return $newPrice;
    }
    public function getWishes(){
        if (auth()->user() != null) {
            $userWishList = User::where('id', auth()->user()->id)->where('wishlist', 'like', '%' . ',' . $this->id . ',' . '%')
                ->orwhere('wishlist', 'like', '%' . ',' . $this->id . ']' . '%')
                ->orwhere('wishlist', 'like', '%' . '[' . $this->id . ',' . '%')
                ->orwhere('wishlist', 'like', '%' . '[' . $this->id . ']' . '%')->get();
        } else {
            $userWishList = [];
        }
        return $userWishList;
    }
    public function scopeFilter($query){
        $cat = request('cat');
        $minPrice = request('minPrice');
        $maxPrice = request('maxPrice');
        $sort = request('sort');
        $search = request('search');
        if(isset($search) && trim($search) != null){
            $query->where('name' , 'like' , '%'.$search.'%');
        }
        if (isset($cat) && trim($cat) != null) {
            // dd($cat);
            if ($cat != 'all') $query->where('cat_id', intval($cat));
        }
        if (isset($minPrice) && isset($maxPrice)) {
            $query->where('price', '>=', $minPrice)->where('price', '<=', $maxPrice);
        }
        if (isset($sort)) {
            // dd($sort);
            if ($sort == 'newest') $query->orderBy('id', 'desc');
            if ($sort == 'cheep') $query->orderBy('price');
            if ($sort == 'expensive') $query->orderBy('price', 'desc');
            if ($sort == 'off') $query->orderBy('off', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }
        // dd($query);
        return $query;
    }
    public function rate(){
        $comments = Comment::where('pro_id' , $this->id)->where('type' , 'product')->get();
        $allRates = 0;
        foreach($comments as $c){
            $allRates = $allRates + $c->rate;
        }
        // dd($this->id);
            
        $rate = $allRates != 0 ? ceil($allRates / count($comments)) : 0;
        return $rate;
    }
}
