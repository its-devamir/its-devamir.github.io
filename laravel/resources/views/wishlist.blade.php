@extends('layout')
@section('body')
<div class="axil-wishlist-area axil-section-gap">
    <div class="container">
        <div class="product-table-heading">
            <h4 class="title">لیست علاقه مندی های من</h4>
        </div>
        <div class="table-responsive">
            <table class="table axil-product-table axil-wishlist-table">
                <thead>
                    <tr>
                        <th scope="col" class="product-remove"></th>
                        <th scope="col" class="product-thumbnail">محصول</th>
                        <th scope="col" class="product-title"></th>
                        <th scope="col" class="product-price">قیمت</th>
                        <th scope="col" class="product-stock-status">وضعیت</th>
                        <th scope="col" class="product-add-cart"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr id="wish-row{{$p->id}}">
                            <td class="product-remove"><a onclick="addWish(this , {{$p->id}} , true)" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                            <td class="product-thumbnail"><a href="/product/{{$p->slug}}"><img src="{{$p->images[0]}}" alt="{{$p->name}}"></a></td>
                            <td class="product-title"><a href="/product/{{$p->slug}}">{{$p->name}}</a></td>
                            <td class="product-price price" data-title="Price">{{$p->newPrice()}} <span class="currency-symbol">تومان</span></td>
                            <td class="product-stock-status" data-title="Status">{{$p->amount != 0 ? 'موجود' : 'ناموجود'}}</td>
                            <td class="product-add-cart"><a data-bs-target="#quick-choose" data-bs-toggle="modal" onclick="openSizeModal({{$p->id}})" class="axil-btn btn-outline cursor-pointer">افزودن به سبد خرید</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="quick-choose" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="sizeModal">
               
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('customScript')
    <script src="/assets/js/product.js"></script>
    <script>

    </script>
@endsection