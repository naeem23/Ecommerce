@extends('layouts.frontend.app')

@section('title', 'Index')

@section('content')
    
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Order Confirmation</h2>
        <hr>
        <p>Your Order #{{ $order->invoice_number }}</p>
        <p>Thanks for shopping with Larashop, we appreciate it. We're small, independent and family-run, just tryin' to share the love!</p>
        
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($my_orders as $item)
                    <tr>
                        <td class="cart_product">
                            <a href=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{ $item->product_name }}</a></h4>
                            <p>Web ID: {{ $item->product_id }}</p>
                        </td>
                        <td class="cart_price">
                            <p>${{ $item->product_price }}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <p>{{ $item->product_quantity }}</p>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">${{ $item->product_price * $item->product_quantity }}</p>
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Order Sub Total</td>
                                    <td>$ {{ $order->subtotal }}</td>
                                </tr>
                                <tr>
                                    <td>Exo Tax</td>
                                    <td>$ {{ $order->tax }}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Shipping Cost</td>
                                    <td>$ 100.00</td>										
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><span>$ {{ $order->total }}</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div><!--features_items-->

@endsection