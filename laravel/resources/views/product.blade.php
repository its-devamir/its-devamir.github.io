@extends('layout')
@section('pageTitle')
    {{$product->name}}
@endsection
@section('body')
    <!-- Start Shop Area  -->
    <div class="axil-single-product-area axil-section-gap pb--0 bg-color-white">
        <div class="single-product-thumb mb--40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mb--40">
                        <div class="row">
                            <div class="col-lg-10 order-lg-2">
                                <div class="single-product-thumbnail-wrap zoom-gallery">
                                    <div class="single-product-thumbnail product-large-thumbnail-3 axil-product" style="direction:ltr;">
                                        @foreach ($product->images as $i)
                                            <div class="thumbnail">
                                                <a href="{{ $i }}" class="popup-zoom">
                                                    <img src="{{ $i }}" alt="Product Images" class="r-1-1">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($product->off != 0)
                                        <div class="label-block">
                                            <div class="product-badget">{{ $product->off }}% OFF</div>
                                        </div>
                                    @endif
                                    <div class="product-quick-view position-view">
                                        <a href="assets/images/product/product-big-01.png" class="popup-zoom">
                                            <i class="far fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 order-lg-1">
                                <div class="product-small-thumb-3 small-thumb-wrapper"  style="direction:ltr;">
                                    @foreach ($product->images as $i)
                                        <div class="small-thumb-img" >
                                            <img src="{{ $i }}" alt="thumb image" class="r-1-1">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mb--40">
                        <div class="single-product-content">
                            <div class="inner">
                                <h2 class="product-title">{{ $product->name }}</h2>
                                <span class="price-amount"></span>
                                <div class="d-flex align-items-center">
                                    <span class="price text-black fs-1 text-bold">{{ $product->newPrice }}</span>
                                    @if ($product->newPrice != $product->price)
                                        <span
                                            class="price old-price text-decoration-middle ms-3 fs-3">{{ $product->price }}</span>
                                    @endif
                                </div>
                                <div class="product-rating">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="review-link">
                                        <a href="#">(<span>2</span> customer reviews)</a>
                                    </div>
                                </div>
                                {{-- <ul class="product-meta">
                                    <li><i class="fal fa-check"></i>In stock</li>
                                    <li><i class="fal fa-check"></i>Free delivery available</li>
                                    <li><i class="fal fa-check"></i>Sales 30% Off Use Code: MOTIVE30</li>
                                </ul> --}}
                                <p class="description line-clamp-3">{{ $product->about }}</p>

                                <div class="product-variations-wrapper">

                                    <!-- Start Product Variation  -->
                                    {{-- <div class="product-variation">
                                        <h6 class="title">Colors:</h6>
                                        <div class="color-variant-wrapper">
                                            <ul class="color-variant">
                                                <li class="color-extra-01 active"><span><span class="color"></span></span>
                                                </li>
                                                <li class="color-extra-02"><span><span class="color"></span></span>
                                                </li>
                                                <li class="color-extra-03"><span><span class="color"></span></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> --}}
                                    <!-- End Product Variation  -->

                                    <!-- Start Product Variation  -->
                                    <div class="product-variation product-size-variation">
                                        <h6 class="title">سایز:</h6>
                                        <ul class="range-variant">
                                            @foreach ($product->sizes as $s)
                                                <li class="size-box" onclick="setSize({{$s}} , this)">{{ $s }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- End Product Variation  -->

                                </div>

                                <!-- Start Product Action Wrapper  -->
                                <div class="product-action-wrapper d-flex-center">
                                    <!-- Start Quentity Action  -->
                                    <div class="pro-qty"><input id="numberInp" type="text" value="1"></div>
                                    <!-- End Quentity Action  -->

                                    <!-- Start Product Action  -->
                                    <ul class="product-action d-flex-center mb--0">
                                        <li class="add-to-cart"><a class="axil-btn btn-bg-primary" onclick="addCart(this , {{$product->id}})"> افزودن به سبد خرید</a>
                                        </li>
                                        <li class="wishlist"><a onclick="addWish(this , {{$product->id}})" class="axil-btn wishlist-btn"><i
                                                    class="far fa-heart {{$product->wish == 1 ? 'text-danger' : ''}}" id="wish-i{{$product->id}}"></i></a></li>
                                    </ul>
                                    <!-- End Product Action  -->

                                </div>
                                <!-- End Product Action Wrapper  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .single-product-thumb -->

        <div class="woocommerce-tabs wc-tabs-wrapper bg-vista-white">
            <div class="container">
                <ul class="nav tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab"
                            aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <a id="additional-info-tab" data-bs-toggle="tab" href="#additional-info" role="tab"
                            aria-controls="additional-info" aria-selected="false">Additional Information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                            aria-selected="false">Reviews</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                        aria-labelledby="description-tab">
                        <div class="product-desc-wrapper">
                            <div class="row">
                                <div class="col-lg-6 mb--30">
                                    <div class="single-desc">
                                        <h5 class="title">Specifications:</h5>
                                        <p>We’ve created a full-stack structure for our working workflow processes, were
                                            from the funny the century initial all the made, have spare to negatives. But
                                            the structure was from the funny the century rather,
                                            initial all the made, have spare to negatives.</p>
                                    </div>
                                </div>
                                <!-- End .col-lg-6 -->
                                <div class="col-lg-6 mb--30">
                                    <div class="single-desc">
                                        <h5 class="title">Care & Maintenance:</h5>
                                        <p>Use warm water to describe us as a product team that creates amazing UI/UX
                                            experiences, by crafting top-notch user experience.</p>
                                    </div>
                                </div>
                                <!-- End .col-lg-6 -->
                            </div>
                            <!-- End .row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="pro-des-features">
                                        <li class="single-features">
                                            <div class="icon">
                                                <img src="assets/images/product/product-thumb/icon-3.png" alt="icon">
                                            </div>
                                            Easy Returns
                                        </li>
                                        <li class="single-features">
                                            <div class="icon">
                                                <img src="assets/images/product/product-thumb/icon-2.png" alt="icon">
                                            </div>
                                            Quality Service
                                        </li>
                                        <li class="single-features">
                                            <div class="icon">
                                                <img src="assets/images/product/product-thumb/icon-1.png" alt="icon">
                                            </div>
                                            Original Product
                                        </li>
                                    </ul>
                                    <!-- End .pro-des-features -->
                                </div>
                            </div>
                            <!-- End .row -->
                        </div>
                        <!-- End .product-desc-wrapper -->
                    </div>
                    <div class="tab-pane fade" id="additional-info" role="tabpanel"
                        aria-labelledby="additional-info-tab">
                        <div class="product-additional-info">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Stand Up</th>
                                            <td>35″L x 24″W x 37-45″H(front to back wheel)</td>
                                        </tr>
                                        <tr>
                                            <th>Folded (w/o wheels) </th>
                                            <td>32.5″L x 18.5″W x 16.5″H</td>
                                        </tr>
                                        <tr>
                                            <th>Folded (w/ wheels) </th>
                                            <td>32.5″L x 24″W x 18.5″H</td>
                                        </tr>
                                        <tr>
                                            <th>Door Pass Through </th>
                                            <td>24</td>
                                        </tr>
                                        <tr>
                                            <th>Frame </th>
                                            <td>Aluminum</td>
                                        </tr>
                                        <tr>
                                            <th>Weight (w/o wheels) </th>
                                            <td>20 LBS</td>
                                        </tr>
                                        <tr>
                                            <th>Weight Capacity </th>
                                            <td>60 LBS</td>
                                        </tr>
                                        <tr>
                                            <th>Width</th>
                                            <td>24″</td>
                                        </tr>
                                        <tr>
                                            <th>Handle height (ground to handle) </th>
                                            <td>37-45″</td>
                                        </tr>
                                        <tr>
                                            <th>Wheels</th>
                                            <td>Aluminum</td>
                                        </tr>
                                        <tr>
                                            <th>Size</th>
                                            <td>S, M, X, XL</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews-wrapper">
                            <div class="row">
                                <div class="col-lg-6 mb--40">
                                    <div class="axil-comment-area pro-desc-commnet-area">
                                        <h5 class="title">01 Review for this product</h5>
                                        <ul class="comment-list">
                                            <!-- Start Single Comment  -->
                                            <li class="comment">
                                                <div class="comment-body">
                                                    <div class="single-comment">
                                                        <div class="comment-img">
                                                            <img src="./assets/images/blog/author-image-4.png"
                                                                alt="Author Images">
                                                        </div>
                                                        <div class="comment-inner">
                                                            <h6 class="commenter">
                                                                <a class="hover-flip-item-wrapper" href="#">
                                                                    <span class="hover-flip-item">
                                                                        <span data-text="Cameron Williamson">Eleanor
                                                                            Pena</span>
                                                                    </span>
                                                                </a>
                                                                <span class="commenter-rating ratiing-four-star">
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i
                                                                            class="fas fa-star empty-rating"></i></a>
                                                                </span>
                                                            </h6>
                                                            <div class="comment-text">
                                                                <p>“We’ve created a full-stack structure for our working
                                                                    workflow processes, were from the funny the century
                                                                    initial all the made, have spare to negatives. ” </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Single Comment  -->

                                            <!-- Start Single Comment  -->
                                            <li class="comment">
                                                <div class="comment-body">
                                                    <div class="single-comment">
                                                        <div class="comment-img">
                                                            <img src="./assets/images/blog/author-image-4.png"
                                                                alt="Author Images">
                                                        </div>
                                                        <div class="comment-inner">
                                                            <h6 class="commenter">
                                                                <a class="hover-flip-item-wrapper" href="#">
                                                                    <span class="hover-flip-item">
                                                                        <span data-text="Rahabi Khan">Courtney Henry</span>
                                                                    </span>
                                                                </a>
                                                                <span class="commenter-rating ratiing-four-star">
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                </span>
                                                            </h6>
                                                            <div class="comment-text">
                                                                <p>“We’ve created a full-stack structure for our working
                                                                    workflow processes, were from the funny the century
                                                                    initial all the made, have spare to negatives. ”</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Single Comment  -->

                                            <!-- Start Single Comment  -->
                                            <li class="comment">
                                                <div class="comment-body">
                                                    <div class="single-comment">
                                                        <div class="comment-img">
                                                            <img src="./assets/images/blog/author-image-5.png"
                                                                alt="Author Images">
                                                        </div>
                                                        <div class="comment-inner">
                                                            <h6 class="commenter">
                                                                <a class="hover-flip-item-wrapper" href="#">
                                                                    <span class="hover-flip-item">
                                                                        <span data-text="Rahabi Khan">Devon Lane</span>
                                                                    </span>
                                                                </a>
                                                                <span class="commenter-rating ratiing-four-star">
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                    <a href="#"><i class="fas fa-star"></i></a>
                                                                </span>
                                                            </h6>
                                                            <div class="comment-text">
                                                                <p>“We’ve created a full-stack structure for our working
                                                                    workflow processes, were from the funny the century
                                                                    initial all the made, have spare to negatives. ” </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Single Comment  -->
                                        </ul>
                                    </div>
                                    <!-- End .axil-commnet-area -->
                                </div>
                                <!-- End .col -->
                                <div class="col-lg-6 mb--40">
                                    <!-- Start Comment Respond  -->
                                    <div class="comment-respond pro-des-commend-respond mt--0">
                                        <h5 class="title mb--30">Add a Review</h5>
                                        <p>Your email address will not be published. Required fields are marked *</p>
                                        <div class="rating-wrapper d-flex-center mb--40">
                                            Your Rating <span class="require">*</span>
                                            <div class="reating-inner ml--20">
                                                <a href="#"><i class="fal fa-star"></i></a>
                                                <a href="#"><i class="fal fa-star"></i></a>
                                                <a href="#"><i class="fal fa-star"></i></a>
                                                <a href="#"><i class="fal fa-star"></i></a>
                                                <a href="#"><i class="fal fa-star"></i></a>
                                            </div>
                                        </div>

                                        <form action="#">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Other Notes (optional)</label>
                                                        <textarea name="message" placeholder="Your Comment"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Name <span class="require">*</span></label>
                                                        <input id="name" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Email <span class="require">*</span> </label>
                                                        <input id="email" type="email">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-submit">
                                                        <button type="submit" id="submit"
                                                            class="axil-btn btn-bg-primary w-auto">Submit Comment</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End Comment Respond  -->
                                </div>
                                <!-- End .col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- woocommerce-tabs -->

    </div>
    <!-- End Shop Area  -->

    <!-- Start Recently Viewed Product Area  -->
    <div class="axil-product-area bg-color-white axil-section-gap pb--50 pb_sm--30">
        <div class="container">
            <div class="section-title-wrapper">
                {{-- <span class="title-highlighter highlighter-primary"><i class="far fa-shopping-basket"></i> Your
                    Recently</span> --}}
                <h2 class="title">محصولات مرتبط</h2>
            </div>
            <div class="recent-product-activation slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                @foreach ($suggest as $p)
                    <div class="slick-single-layout">
                        <div class="axil-product">
                            <div class="thumbnail">
                                <a href="single-product.html">
                                    <img src="{{$p->images[0]}}" alt="Product Images" class="r-1-1">
                                </a>
                                @if($p->off != 0)
                                <div class="label-block label-right">
                                    <div class="product-badget">{{$p->off}}% OFF</div>
                                </div>
                                @endif
                                <div class="product-hover-action">
                                    <ul class="cart-action">
                                        <li class="wishlist"><a onclick="addWish(this , {{$p->id}})"><i
                                            class="far fa-heart {{$p->wish == 1 ? 'text-danger' : ''}}" id="wish-i{{$p->id}}"></i></a></li>
                                        <li class="select-option cursor-pointer"><a data-bs-target="#quick-choose" data-bs-toggle="modal" onclick="openSizeModal({{$p->id}})">افزودن به سبد خرید</a></li>
                                        <li class="quickview"><a href="#" data-bs-toggle="modal"
                                            onclick="openProductModal({{$p->id }})"
                                            data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="inner">
                                    <h5 class="title"><a href="single-product.html">{{$p->name}}</a></h5>
                                    <div class="product-price-variant">
                                        <span class="price current-price">{{$p->newPrice}}</span>
                                        @if($p->price != $p->newPrice)
                                            <span class="price old-price">{{$p->price}}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="color-variant-wrapper">
                                        <ul class="color-variant">
                                            <li class="color-extra-01 active"><span><span class="color"></span></span>
                                            </li>
                                            <li class="color-extra-02"><span><span class="color"></span></span>
                                            </li>
                                            <li class="color-extra-03"><span><span class="color"></span></span>
                                            </li>
                                        </ul>   
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


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
    <!-- End Recently Viewed Product Area  -->
@endsection

@section('customScript')
    <script src="assets/js/product.js"></script>
    <script>
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
                

        
    </script>
@endsection
