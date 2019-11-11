<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::content();
        $shipping_cost = 100.00;
        $cart_total = floatval(str_replace(',','', Cart::total()));
        $total = number_format($cart_total + $shipping_cost, 2);
        
        return view('frontend.cart', compact('carts', 'shipping_cost', 'total'));
    }


    
    public function add(Request $request, $id)
    {
        $product = Product::find($id);
        if ($request->quantity) {
            $qty = $request->quantity;
        } else {
            $qty = 1;
        }
        
        Cart::add(['id' => $product->id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->price,'weight' => 0, 'options' => ['size' => $product->size, 'image' => $product->image]]);

        return redirect()->route('cart.index');
    }


    public function increase($id)
    {
        $rowId = $id;
        $qty = Cart::get($rowId)->qty += 1;
        Cart::update($rowId, $qty);
        session()->flash('success', 'Cart updated increasing quantity by 1.');
        return back();
    }


    public function decrease($id)
    {
        $rowId = $id;
        $qty = Cart::get($rowId)->qty -= 1;
        Cart::update($rowId, $qty);
        session()->flash('success', 'Cart updated increasing quantity by 1.');
        return back();
    }


    public function remove($id)
    {
        $rowId = $id;
        Cart::remove($rowId);
        session()->flash('success', '1 Item has removed from cart.');
        return back();
    }
}
