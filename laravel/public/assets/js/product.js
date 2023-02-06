
var newSize = null;
var newNumber = 1;
function setSize(size , el){
    newSize = size;
    for(let i =0; i<$(".size-box").length; i++){
        $(".size-box")[i].classList.remove('border-blue');
    }
    el.classList.add('border-blue');
}
function addCart(el, id ) {
    if (newSize != null) {
        let url = `${mainUrl}/addCart/${id}?size=${newSize}&number=${newNumber}`;
        ajax(
            url,
            {},
            json => {
                if (json.status == "success") {
                    // el.textContent = "افزوده شد";
                    getCart();
                }else if(json.status == 'login'){
                    window.location.assign('/login');
                }
            },
            "POST"
        );
    } else {
        alert("سایز را وارد کنید");
    }
}
function addWish(el , id){
            let url = `${mainUrl}/addWish/${id}`;
            ajax(
                url,
                {},
                json => {
                    if (json.status == "remove") {
                        $(`#wish-i${id}`)[0].classList.remove('text-danger');
                    }else if(json.status == "add"){
                        $(`#wish-i${id}`)[0].classList.add('text-danger');
                    }else if(json.status == 'login'){
                        window.location.assign('/login');
                    }
                },
                "GET"
            );
}


//product pages
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
                                            <div class="pro-qty pro-qty2"><input onkeyup="setNumber(el)" type="text" value="1"></div>
                                            <!-- End Quentity Action  -->

                                            <!-- Start Product Action  -->
                                            <ul class="product-action d-flex-center mb--0">
                                                <li class="add-to-cart"><a
                                                        class="axil-btn btn-bg-primary" onclick="addCart(this , ${json.product.id})" data-bs-dismiss="modal" aria-label="Close">افزودن به سبد خرید</a></li>
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
            $('.pro-qty2').prepend('<span class="dec qtybtn qtybtn2">-</span>');
            $('.pro-qty2').append('<span class="inc qtybtn qtybtn2">+</span>');
            $('.qtybtn2').on('click', function() {
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
                        <div class="pro-qty pro-qty3">
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
                <button  class="btn btn-danger w-fit mx-auto mt-4 py-3 px-4 rounded-4 fs-3" onclick="addCart(this , ${id})" data-bs-dismiss="modal" aria-label="Close">افزودن</button>         
                `;
                $("#sizeModal")[0].innerHTML = sizeModal;

                $('.pro-qty3').prepend('<span class="dec qtybtn qtybtn3">-</span>');
                $('.pro-qty3').append('<span class="inc qtybtn qtybtn3">+</span>');
                $('.qtybtn3').on('click', function() {
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