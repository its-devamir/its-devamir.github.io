<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    public $u;
    public function __construct()
    {
        if (isset($_COOKIE['thunder_token'])) {
            $id = $_COOKIE['thunder_id'];
            $token = $_COOKIE['thunder_token'];
            $user = User::where('api_token', '=', $token)->whereId($id)->first();
            auth()->login($user);
        }
    }
    
}
