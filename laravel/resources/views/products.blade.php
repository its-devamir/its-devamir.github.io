@extends('layout')
@section('pageTitle')
    محصولات
@endsection
@section('body')
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">حساب کاربری من</li>
                        </ul>
                        <h1 class="title text-bold">محصولی که میخوای رو پیدا کن</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4">
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
        let productModal = $("#productModal")[0];
        
        let images ="";
        let smallImages = "";
        let sizes = "";
        function openProductModal(id) {
            sizes = '';
            images = "";
            smallImages = "";
            let productBody = '';
            productModal.innerHTML = '<div class="loading"><img src="/assets/images/icons/loading.svg"></div>';
            loading();
            let url = `${mainUrl}/getProduct?id=${id}`;
            ajax(url, {}, json => {
                if ((json.status == 'success')) {
                    json.product.images.forEach(img => {
                        images +=`
                        <div class="thumbnail">
                            <img src="${img}" alt="Product Images">
                            <div class="label-block label-right">
                                <div class="product-badget">20% OFF</div>
                            </div>
                            <div class="product-quick-view position-view">
                                <a href="${img}" class="popup-zoom">
                                    <i class="far fa-search-plus"></i>
                                </a>
                            </div>
                        </div>
                        `;
                    });
                    json.product.images.forEach(img => {
                        smallImages +=`
                        <div class="small-thumb-img">
                            <img src="${img}"
                                alt="thumb image">
                        </div>
                        `;
                    });
                    if(json.product.sizes.length > 0){
                        json.product.sizes.forEach(s=>{
                            sizes +=`<li id="sizeLi${s}" class="size-box" onclick="setSize(${s} , this)">${s}</li>`;
                        })
                    }else{
                        sizes = null;
                    }
                    productBody = `
                    <div class="single-product-thumb">
                        <div class="row">
                            <div class="col-lg-7 mb--40">
                                <div class="row">
                                    <div class="col-lg-10 order-lg-2">
                                        <div
                                            class="single-product-thumbnail product-large-thumbnail axil-product thumbnail-badge zoom-gallery" style="direction:ltr;">
                                            ${images}
                                        </div>
                                    </div>
                                    <div class="col-lg-2 order-lg-1">
                                        <div class="product-small-thumb small-thumb-wrapper"  style="direction:ltr;">
                                            ${smallImages}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 mb--40">
                                <div class="single-product-content">
                                    <div class="inner">
                                        <div class="product-rating">
                                            <div class="star-rating">
                                                <img src="assets/images/icons/rate.png" alt="Rate Images">
                                            </div>
                                            <div class="review-link">
                                                <a href="#">(<span>1</span> customer reviews)</a>
                                            </div>
                                        </div>
                                        <h3 class="product-title">${json.product.name}</h3>
                                        <span class="price text-black fs-1 text-bold">${json.product.newPrice}</span>
                                        ${json.product.newPrice != json.product.price ? `
                                            <span
                                                class="price old-price text-decoration-middle ms-3 fs-3">${json.product.price}</span>
                                       ` : ''}
                                        {{--<ul class="product-meta">
                                            <li><i class="fal fa-check"></i>In stock</li>
                                            <li><i class="fal fa-check"></i>Free delivery available</li>
                                            <li><i class="fal fa-check"></i>Sales 30% Off Use Code: MOTIVE30</li>
                                        </ul> --}}
                                        <p class="description linne-clamp-3">${json.product.about}</p>

                                        <div class="product-variations-wrapper">

                                            <!-- Start Product Variation  -->
                                            {{--<div class="product-variation">
                                                <h6 class="title">Colors:</h6>
                                                <div class="color-variant-wrapper">
                                                    <ul class="color-variant mt--0">
                                                        <li class="color-extra-01 active"><span><span
                                                                    class="color"></span></span>
                                                        </li>
                                                        <li class="color-extra-02"><span><span
                                                                    class="color"></span></span>
                                                        </li>
                                                        <li class="color-extra-03"><span><span
                                                                    class="color"></span></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> --}}
                                            <!-- End Product Variation  -->

                                            <!-- Start Product Variation  -->
                                            ${sizes != null ? `
                                                <div class="product-variation">
                                                    <h6 class="title">سایز:</h6>
                                                    <ul class="range-variant">
                                                        ${sizes}
                                                    </ul> 
                                                </div>
                                            ` : ''}
                                            <!-- End Product Variation  -->

                                        </div>

                                        <!-- Start Product Action Wrapper  -->
                                        <div class="product-action-wrapper d-flex-center">
                                            <!-- Start Quentity Action  -->
                                            <div class="pro-qty"><input onkeyup="setNumber(el)" type="text" value="1"></div>
                                            <!-- End Quentity Action  -->

                                            <!-- Start Product Action  -->
                                            <ul class="product-action d-flex-center mb--0">
                                                <li class="add-to-cart"><a
                                                        class="axil-btn btn-bg-primary" onclick="addCart(this , ${json.product.id})">افزودن به سبد خرید</a></li>
                                                <li class="wishlist"><a onclick="addWish(this , ${json.product.id})"
                                                        class="axil-btn wishlist-btn"><i class="far fa-heart" id="wish-i${json.product.id}"></i></a>
                                                </li>
                                            </ul>
                                            <!-- End Product Action  -->

                                        </div>
                                        <!-- End Product Action Wrapper  -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    // console.log(productBody);
                    productModal.innerHTML = productBody;
                $('.product-small-thumb').slick({
                infinite: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                focusOnSelect: true,
                vertical: true,
                speed: 800,
                asNavFor: '.product-large-thumbnail',
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            vertical: false,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            vertical: false,
                            slidesToShow: 4,
                        }
                    }
                ]

            });

            $('.product-large-thumbnail').slick({
                infinite: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                speed: 800,
                draggable: false,
                asNavFor: '.product-small-thumb'
            });
            let price2 = document.getElementsByClassName('price');
            let d2 = ''
            for(let i = 0; i<price2.length; i++) {
                d2 = price2[i].textContent.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                price2[i].textContent = d2;
            };
            $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
            $('.pro-qty').append('<span class="inc qtybtn">+</span>');
            $('.qtybtn').on('click', function() {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                newNumber = newVal;
                $button.parent().find('input').val(newVal);
            });
                }
            }, "GET")
        }

        function setSort(el){
            $("#sortInp").val(el.value);
        }
        // $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
        // $('.pro-qty').append('<span class="inc qtybtn">+</span>');
        let sizeModal = '';
        let smallSizes = '';
        function openSizeModal(id){
            smallSizes = '';
            let url = `${mainUrl}/getSizes?id=${id}`;
            ajax(url , {} , json=>{
                json.sizes.forEach(s=>{
                    smallSizes +=`<li id="sizeLi${s}" class="size-box" onclick="setSize(${s} , this)">${s}</li>`;
                })
                sizeModal=`
                <div class="d-flex  w-fit mx-auto align-items-center mt-3">
                        <span>تعداد</span>
                        <div class="pro-qty">
                            <input onkeyup="setNumber(el)" type="text" value="1"></div>
                    </div>
                    <div id="sizeModal" class="my-4">
                        <div class="product-variation d-flex align-items-center w-fit mx-auto">
                            <span class="">سایز:</span>
                            <ul class="range-variant">
                                ${smallSizes}
                            </ul> 
                        </div>       

                    </div>
                <button  class="btn btn-danger w-fit mx-auto mt-4 py-3 px-4 rounded-4 fs-3" onclick="addCart(this , ${id})">افزودن</button>         
                `;
                $("#sizeModal")[0].innerHTML = sizeModal;

                $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
            $('.pro-qty').append('<span class="inc qtybtn">+</span>');
            $('.qtybtn').on('click', function() {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                newNumber = newVal;
                $button.parent().find('input').val(newVal);
            });
            },"GET")
        }
        
    </script>
@endsection
