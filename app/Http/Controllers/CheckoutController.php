<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\Shipping;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::content();
        $shipping_cost = 100.00;
        $cart_total = floatval(str_replace(',','', Cart::total()));
        $total = number_format($cart_total + $shipping_cost, 2);

        return view('frontend.chechout', compact('carts', 'shipping_cost', 'total'));
    }


    // public function orderConfirm()
    // {
    //     return view('frontend.order_confirmation');
    // }


    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'       => 'required',
            'last_name'        => 'required',
            'email'            => 'required | email',
            'mobile'           => 'required',
            'address'          => 'required',
            'zip'              => 'required',
            'payment_method'   => 'required',
        ]);

        $shipping = new Shipping();
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email;
        $shipping->mobile = $request->mobile;
        $shipping->address = $request->address;
        $shipping->zip = $request->zip;
        if ($request->shipping_to_bill == 'on') {
            $shipping->shipping_to_bill = 1;
        }
        $shipping->save();

        $payment = new Payment();
        $payment->method = $request->payment_method;
        $payment->save();

        $carts = Cart::content();
        $shipping_cost = 100.00;
        $cart_total = floatval(str_replace(',','', Cart::total()));
        $total = number_format($cart_total + $shipping_cost, 2);

        $order = new Order();
        $order->invoice_number = uniqid();
        $order->user_id = Auth::id();
        $order->shipping_id = $shipping->id;
        $order->payment_id = $payment->id;
        $order->total = $total;
        $order->subtotal = Cart::subtotal();
        $order->tax = Cart::tax();
        $order->save();

        foreach($carts as $cart){
            $order_details = new OrderDetail();
            $order_details->order_id = $order->id;
            $order_details->product_id = $cart->id;
            $order_details->product_name = $cart->name;
            $order_details->product_price = $cart->price;
            $order_details->product_quantity = $cart->qty;
            $order_details->save();
        }

        Cart::destroy();

        return redirect()->route('order.confirm');
    }

    public function orderConfirm()
    {
        $user_id = Auth::id();
        $order = Order::where('user_id', $user_id)->latest()->firstOrFail();
        $my_orders = OrderDetail::where('order_id', $order->id)->get();

        return view('frontend.order_confirmation', compact('order', 'my_orders'));
    }
}

