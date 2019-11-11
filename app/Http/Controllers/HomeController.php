<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$products = Product::all();
        return view('frontend.home', compact('products'));
    }


    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('frontend.product', compact('product'));
    }
}
