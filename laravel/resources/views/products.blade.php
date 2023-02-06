@extends('layout')
@section('pageTitle')
    محصولات
@endsection
@section('body')
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">حساب کاربری من</li>
                        </ul>
                        <h1 class="title text-bold">محصولی که میخوای رو پیدا کن</h1>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4">
                    <div class="inner">
                        <div class="bradcrumb-thumb">
                            <img src="assets/images/product/product-45.png" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start Shop Area  -->
    <div class="axil-shop-area axil-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <form method="GET">
                        <div class="axil-shop-sidebar">
                            <div class="d-lg-none">
                                <button class="sidebar-close filter-close-btn"><i class="fas fa-times"></i></button>
                            </div>
                            <input type="hidden" name="sort" id="sortInp" value="newest">
                            <div class="toggle-list product-categories active">
                                <h6 class="title">CATEGORIES</h6>
                                <div class="shop-submenu">
                                    <ul>
                                        <li class="">  <input type="radio" name="cat" id="cat" class="categories-radio" checked value="all">
                                            <span>همه</span></li>
                                        @foreach ($categories as $c)
                                            <li class="">  <input type="radio" name="cat" id="cat" class="categories-radio" value="{{$c->id}}">
                                                <span>{{ $c->name }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="toggle-list product-categories product-gender active">
                                <h6 class="title">GENDER</h6>
                                <div class="shop-submenu">
                                    <ul>
                                        <li class="chosen"><a href="#">Men (40)</a></li>
                                        <li><a href="#">Women (56)</a></li>
                                        <li><a href="#">Unisex (18)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="toggle-list product-color active">
                                <h6 class="title">COLORS</h6>
                                <div class="shop-submenu">
                                    <ul>
                                        <li class="chosen"><a href="#" class="color-extra-01"></a></li>
                                        <li><a href="#" class="color-extra-02"></a></li>
                                        <li><a href="#" class="color-extra-03"></a></li>
                                        <li><a href="#" class="color-extra-04"></a></li>
                                        <li><a href="#" class="color-extra-05"></a></li>
                                        <li><a href="#" class="color-extra-06"></a></li>
                                        <li><a href="#" class="color-extra-07"></a></li>
                                        <li><a href="#" class="color-extra-08"></a></li>
                                        <li><a href="#" class="color-extra-09"></a></li>
                                        <li><a href="#" class="color-extra-10"></a></li>
                                        <li><a href="#" class="color-extra-11"></a></li>
                                    </ul>
                                </div>
                            </div> --}}

                            {{-- <div class="toggle-list product-size active">
                                <h6 class="title">SIZE</h6>
                                <div class="shop-submenu">
                                    <ul>
                                        <li class="chosen"><a href="#">XS</a></li>
                                        <li><a href="#">S</a></li>
                                        <li><a href="#">M</a></li>
                                        <li><a href="#">L</a></li>
                                        <li><a href="#">XL</a></li>
                                        <li><a href="#">XXL</a></li>
                                        <li><a href="#">3XL</a></li>
                                        <li><a href="#">4XL</a></li>
                                    </ul>
                                </div>
                            </div> --}}
                            <div class="toggle-list product-price-range active">
                                <h6 class="title">قیمت</h6>
                                <div class="shop-submenu">
                                    {{-- <ul>
                                    <li class="chosen"><a href="#">30</a></li>
                                    <li><a href="#">5000</a></li>
                                </ul> --}}
                                    <form action="#" class="mt--25">
                                        <div id="slider-range"></div>
                                        <div class="flex-center mt--20">
                                            <input type="text" id="amount" class="amount-range"
                                                readonly>
                                                <input type="hidden" name="minPrice" id="minPrice">
                                                <input type="hidden" name="maxPrice" id="maxPrice">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <button class="axil-btn btn-bg-primary" type="submit">فیلتر کن!</button>
                        </div>
                    </form>
                    <!-- End .axil-shop-sidebar -->
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="axil-shop-top mb--40">
                                <div
                                    class="category-select align-items-center justify-content-lg-end justify-content-between">
                                    <!-- Start Single Select  -->
                                    <span class="filter-results"></span>
                                    <select class="single-select" id="sort" onchange="setSort(this)">
                                        <option value="newest">جدیدترین ها</option>
                                        <option value="cheep">ارزان ترین ها</option>
                                        <option value="expensive">گران ترین ها</option>
                                        <option value="">پرفرروش ترین ها</option>
                                        <option value="off">تخفیف دارها</option>
                                    </select>
                                    <!-- End Single Select  -->
                                </div>
                                <div class="d-lg-none">
                                    <button class="product-filter-mobile filter-toggle"><i class="fas fa-filter"></i>
                                        فیلتر</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                    @if(count($products) > 0)
                        <div class="row row--15">
                            @foreach ($products as $p)
                                <div class="col-xl-4 col-sm-6">
                                    <div class="axil-product product-style-one mb--30">
                                        <div class="thumbnail">
                                            <a href="/product/{{ $p->slug }}">
                                                <img src="{{ $p->images[0] }}" alt="Product Images" class="r-1-1">
                                            </a>
                                            @if ($p->off != 0)
                                                <div class="label-block label-right">
                                                    <div class="product-badget">{{ $p->off }}% OFF</div>
                                                </div>
                                            @endif
                                            <div class="product-hover-action">
                                                <ul class="cart-action">
                                                    <li class="wishlist"><a onclick="addWish(this , {{$p->id}})"><i
                                                                class="far fa-heart {{$p->wish == 1 ? 'text-danger' : ''}}" id="wish-i{{$p->id}}"></i></a></li>
                                                    <li class="select-option cursor-pointer"><a  data-bs-target="#quick-choose" data-bs-toggle="modal" onclick="openSizeModal({{$p->id}})">افزودن به سبد خرید</a></li>
                                                    <li class="quickview"><a href="#" data-bs-toggle="modal"
                                                            onclick="openProductModal({{$p->id }})"
                                                            data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="inner">
                                                <h5 class="title"><a
                                                        href="/product/{{ $p->slug }}">{{ $p->name }}</a></h5>
                                                <div class="product-price-variant">
                                                    <span class="price current-price">{{ $p->newPrice }}</span>
                                                    @if ($p->newPrice != $p->price)
                                                        <span class="price old-price">{{ $p->price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center pt--20">
                            <a href="#" class="axil-btn btn-bg-lighter btn-load-more">نمایش بیشتر</a>
                        </div>
                    @else
                        <p>محصولی برای نمایش وجود ندارد</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- End .container -->
    </div>
    <!-- End Shop Area  -->
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
    <div class="modal fade quick-view-product" id="quick-view-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="far fa-times"></i></button>
                </div>
                <div class="modal-body" id="productModal">
                
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customScript')
    <script src="assets/js/product.js"></script>
    <script>
        
        function setSort(el){
            $("#sortInp").val(el.value);
        }
        
        
    </script>
@endsection
