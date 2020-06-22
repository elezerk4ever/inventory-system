<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $remainingItems = 0;
        $products = \App\Product::all();
        foreach($products as $product){
            $remainingItems += $product->qty;
        }
        return view('home',compact('remainingItems'));
    }
}
