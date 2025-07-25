<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request){
    $store = User::where('username', $request->username)->first();

    if(!$store){    
        abort(404);
    }   

    $populars = Product::where('user_id', $store->id)->where('is_popular', true)->Get();
    $products = Product::where('user_id', $store->id)->where('is_popular', false)->Get();

    return view('pages.index',compact('store','populars', 'products'));
   }
}
