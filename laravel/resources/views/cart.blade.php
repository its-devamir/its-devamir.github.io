@extends('layout')
@section('body')
<div class="axil-product-cart-area axil-section-gap">
    <div class="container">
        <div class="axil-product-cart-wrap">
            <div class="product-table-heading">
                <h4 class="title">Your Cart</h4>
                <a href="#" class="cart-clear">Clear Shoping Cart</a>
            </div>
            <div class="table-responsive">
                <table class="table axil-product-table axil-cart-table mb--40">
                    <thead>
                        <tr>
                            <th scope="col" class="product-remove"></th>
                            <th scope="col" class="product-thumbnail">محصول</th>
                            <th scope="col" class="product-title"></th>
                            <th scope="col" class="product-price">قیمت</th>
                            <th scope="col" class="product-quantity">تعداد</th>
                            <th scope="col" class="product-subtotal">قیمت نهایی</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                        <tr id="cart-row{{$p->cart_id}}">
                            <td class="product-remove"><a onclick="deleteCartItem({{$p->cart_id}} , true)" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                            <td class="product-thumbnail"><a href="/product/{{$p->slug}}"><img src="{{$p->images[0]}}" alt="{{$p->name}}"></a></td>
                            <td class="product-title"><a href="/product/{{$p->slug}}">{{$p->name}} (سایز: {{$p->size}})</a></td>
                            <td class="product-price price" data-title="Price">{{$p->newPrice}} <span class="currency-symbol">تومان</span></td>
                            <td class="product-quantity" data-title="Qty">
                                <div class="pro-qty">
                                    <input type="number" class="quantity-input" value="{{$p->number}}">
                                </div>
                            </td>
                            <td class="product-subtotal price" data-title="Subtotal">{{$p->subTotal}} <span class="currency-symbol">تومان</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="cart-update-btn-area">
                <div class="input-group product-cupon">
                    <input placeholder="Enter coupon code" type="text">
                    <div class="product-cupon-btn">
                        <button type="submit" class="axil-btn btn-outline">Apply</button>
                    </div>
                </div>
                <div class="update-btn">
                    <a href="#" class="axil-btn btn-outline">Update Cart</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-7 offset-xl-7 offset-lg-5">
                    <div class="axil-order-summery mt--80">
                        <h5 class="title mb--20">Order Summary</h5>
                        <div class="summery-table-wrap">
                            <table class="table summery-table mb--30">
                                <tbody>
                                    <tr class="order-subtotal">
                                        <td>Subtotal</td>
                                        <td>$117.00</td>
                                    </tr>
                                    <tr class="order-shipping">
                                        <td>Shipping</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="radio" id="radio1" name="shipping" checked>
                                                <label for="radio1">Free Shippping</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="radio" id="radio2" name="shipping">
                                                <label for="radio2">Local: $35.00</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="radio" id="radio3" name="shipping">
                                                <label for="radio3">Flat rate: $12.00</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="order-tax">
                                        <td>State Tax</td>
                                        <td>$8.00</td>
                                    </tr>
                                    <tr class="order-total">
                                        <td>Total</td>
                                        <td class="order-total-amount">$125.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="checkout.html" class="axil-btn btn-bg-primary checkout-btn">Process to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection