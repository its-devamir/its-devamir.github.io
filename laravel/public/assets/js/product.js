function load(el = null) {
    let products = "";
    let page=1;
    if (el != null) {
         page = Number(el.dataset.page);
        el.setAttribute('data-page',  page+ 1);
    }
    let params = String(window.location.search).substring(1);
    
    let productUrl = `${mainUrl}/getProducts?page=${page}&${params}`;
    ajax(
        productUrl,
        {},
        (json) => {
            if(json.products.last_page == 1) $("#loadMoreProducts").remove();
            json.products.data.forEach((p) => {
                products += `
            <div class="col-xl-4 col-sm-6">
            <div class="axil-product product-style-one mb--30">
                <div class="thumbnail">
                    <a href="/product/${p.slug}">
                        <img src="${
                            p.images[0]
                        }" alt="Product Images" class="r-1-1">
                    </a>
                    ${
                        p.off != 0
                            ? `
                        <div class="label-block label-right">
                            <div class="product-badget">${p.off}% OFF</div>
                        </div>
                    `
                            : ""
                    }
                    <div class="product-hover-action">
                        <ul class="cart-action">
                            <li class="wishlist"><a class=" ${
                                p.wish == 1 ? "wishShow" : ""
                            }" onclick="addWish(this , ${
                                p.id
                            })"><i
                                        class="far fa-heart" id="wish-i${p.id}"></i></a></li>
                            <li class="select-option cursor-pointer"><a  data-bs-target="#quick-choose" data-bs-toggle="modal" onclick="openSizeModal(${
                                p.id
                            })">افزودن به سبد خرید</a></li>
                            <li class="quickview"><a href="#" data-bs-toggle="modal"
                                    onclick="openProductModal(${p.id})"
                                    data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-content">
                    <div class="inner">
                        <h5 class="title"><a
                                href="/product/${p.slug}">${p.name}</a></h5>
                        <div class="product-price-variant">
                            <span class="price current-price">${
                                p.newPrice
                            }</span>
                            ${
                                p.newPrice != p.price
                                    ? `
                                <span class="price old-price">${p.price}</span>
                            `
                                    : ""
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
            `;
            // console.log(json.products.data.length);
            });
            
            if(el == null){
                
                $("#productLoading").remove();
            }else{
                if(json.products.last_page == page){
                    el.remove();
                }
            }
            $("#products-container")[0].innerHTML += products;
            for (let i = 0; i < $('.price').length; i++) {
                $(".price")[i].textContent = $(".price")[i].textContent.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        "GET"
    );
}
var newSize = null;
var newNumber = 1;
function setSize(size, el) {
    newSize = size;
    for (let i = 0; i < $(".size-box").length; i++) {
        $(".size-box")[i].classList.remove("border-blue");
    }
    el.classList.add("border-blue");
}
function addCart(el, id) {
    if (newSize != null) {
        let url = `${mainUrl}/addCart/${id}?size=${newSize}&number=${newNumber}`;
        ajax(
            url,
            {},
            (json) => {
                if (json.status == "success") {
                    // el.textContent = "افزوده شد";
                    getCart();
                } else if (json.status == "login") {
                    window.location.assign("/login");
                }
            },
            "POST"
        );
    } else {
        alert("سایز را وارد کنید");
    }
}


//product pages
let productModal = $("#productModal")[0];

let images = "";
let smallImages = "";
let sizes = "";
function openProductModal(id) {
    sizes = "";
    images = "";
    smallImages = "";
    let productBody = "";
    productModal.innerHTML =
        '<div class="loading"><img src="/assets/images/icons/loading.svg"></div>';
    loading();
    let url = `${mainUrl}/getProduct?id=${id}`;
    ajax(
        url,
        {},
        (json) => {
            if (json.status == "success") {
                json.product.images.forEach((img) => {
                    images += `
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
                json.product.images.forEach((img) => {
                    smallImages += `
                        <div class="small-thumb-img">
                            <img src="${img}"
                                alt="thumb image">
                        </div>
                        `;
                });
                if (json.product.sizes.length > 0) {
                    json.product.sizes.forEach((s) => {
                        sizes += `<li id="sizeLi${s}" class="size-box" onclick="setSize(${s} , this)">${s}</li>`;
                    });
                } else {
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
                                        <h3 class="product-title">${
                                            json.product.name
                                        }</h3>
                                        <span class="price text-black fs-1 text-bold">${
                                            json.product.newPrice
                                        }</span>
                                        ${
                                            json.product.newPrice !=
                                            json.product.price
                                                ? `
                                            <span
                                                class="price old-price text-decoration-middle ms-3 fs-3">${json.product.price}</span>
                                       `
                                                : ""
                                        }
                                        <!-- <ul class="product-meta">
                                            <li><i class="fal fa-check"></i>In stock</li>
                                            <li><i class="fal fa-check"></i>Free delivery available</li>
                                            <li><i class="fal fa-check"></i>Sales 30% Off Use Code: MOTIVE30</li>
                                        </ul> -->
                                        <p class="description linne-clamp-3">${
                                            json.product.about
                                        }</p>

                                        <div class="product-variations-wrapper">

                                            <!-- Start Product Variation  -->
                                            <!--<div class="product-variation">
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
                                            </div> -->
                                            <!-- End Product Variation  -->

                                            <!-- Start Product Variation  -->
                                            ${
                                                sizes != null
                                                    ? `
                                                <div class="product-variation">
                                                    <h6 class="title">سایز:</h6>
                                                    <ul class="range-variant">
                                                        ${sizes}
                                                    </ul> 
                                                </div>
                                            `
                                                    : ""
                                            }
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
                                                        class="axil-btn btn-bg-primary" onclick="addCart(this , ${
                                                            json.product.id
                                                        })" data-bs-dismiss="modal" aria-label="Close">افزودن به سبد خرید</a></li>
                                                <li class="wishlist"><a onclick="addWish(this , ${
                                                    json.product.id
                                                })"
                                                        class="axil-btn wishlist-btn ${json.product.wish == 1 ? 'wishShow' : ''}"><i class="far fa-heart ""></i></a>
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
                $(".product-small-thumb").slick({
                    infinite: false,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    focusOnSelect: true,
                    vertical: true,
                    speed: 800,
                    asNavFor: ".product-large-thumbnail",
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                vertical: false,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                vertical: false,
                                slidesToShow: 4,
                            },
                        },
                    ],
                });

                $(".product-large-thumbnail").slick({
                    infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    speed: 800,
                    draggable: false,
                    asNavFor: ".product-small-thumb",
                });
                let price2 = document.getElementsByClassName("price");
                let d2 = "";
                for (let i = 0; i < price2.length; i++) {
                    d2 = price2[i].textContent
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    price2[i].textContent = d2;
                }
                $(".pro-qty2").prepend(
                    '<span class="dec qtybtn qtybtn2">-</span>'
                );
                $(".pro-qty2").append(
                    '<span class="inc qtybtn qtybtn2">+</span>'
                );
                $(".qtybtn2").on("click", function () {
                    var $button = $(this);
                    var oldValue = $button.parent().find("input").val();
                    if ($button.hasClass("inc")) {
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
                    $button.parent().find("input").val(newVal);
                });
            }
        },
        "GET"
    );
}

let sizeModal = "";
let smallSizes = "";
function openSizeModal(id) {
    smallSizes = "";
    let url = `${mainUrl}/getSizes?id=${id}`;
    ajax(
        url,
        {},
        (json) => {
            json.sizes.forEach((s) => {
                smallSizes += `<li id="sizeLi${s}" class="size-box" onclick="setSize(${s} , this)">${s}</li>`;
            });
            sizeModal = `
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

            $(".pro-qty3").prepend('<span class="dec qtybtn qtybtn3">-</span>');
            $(".pro-qty3").append('<span class="inc qtybtn qtybtn3">+</span>');
            $(".qtybtn3").on("click", function () {
                var $button = $(this);
                var oldValue = $button.parent().find("input").val();
                if ($button.hasClass("inc")) {
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
                $button.parent().find("input").val(newVal);
            });
        },
        "GET"
    );
}



function addWish(el, id) {
    let url = `${mainUrl}/addWish/${id}`;
    ajax(
        url,
        {},
        (json) => {
            if (json.status == "remove") {
                el.classList.remove("wishShow");
            } else if (json.status == "add") {
                el.classList.add("wishShow");
            } else if (json.status == "login") {
                window.location.assign("/login");
            }
        },
        "GET"
    );
}
function inputError(el){
    console.log(el);
    el.classList.add('border' , 'border-danger')
}
let validate = true;
function ableLength(el){
    let supportLength = $("#supportLength")[0];
    let submit = $("#submitRate")[0];
    let maxLength = 250;
    let strLength = el.value.length;
    let charRemain = (maxLength - strLength);
    if(strLength != 0){ 
        if(charRemain<0){
            supportLength.innerHTML = `<span class='text-danger'>حداکثر ${maxLength} کاراکتر مجاز است </span>`;
            submit.disabled = true;
            validate = false;
            inputError(el);

        }else{
            supportLength.innerHTML = `<span class='text-success'>${charRemain} کاراکتر باقیمانده </span>`;
            submit.disabled = false;
            validate = true;
        }
    }else{
        supportLength.innerHTML = "";
        submit.disabled = true;
        validate = false
        inputError(el);
    }
}


//rate
let newRate = 0;
function setrate(el){
    newRate = el.value;
    for(let i =0; i<$(".pro-rate").length; i++){
        $(".pro-rate")[i].classList.remove('show')
    }
    $(`#rateLabelNum${el.value}`)[0].classList.add('show');
}

function addRate(el){
    validate = true;
    console.log(newRate);
    // console.log($("#nameRate")[0].value.length);
    // if($("#nameRate")[0].value.length == 0){
    //     inputError($("#nameRate")[0]);
    //     validate = false;
    // }
    // if($("#emailRate")[0].value.length == 0){
    //     inputError($("#emailRate")[0]);
    //     validate = false;
    // }
    if($("#bodyRate")[0].value.length == 0){
        inputError($("#bodyRate")[0]);
        validate = false;
    }
    if(newRate == 0){
        $(".rating-wrapper")[0].classList.add('text-danger');
        validate = false;
    }else{
        $(".rating-wrapper")[0].classList.remove('text-danger');
    }
    if(validate){
        let rateUrl = `${mainUrl}/sendRate`;
        let params = {
            'pro_id' : $("#product_id")[0].value,
            'rate' : newRate,
            'body' : $("#bodyRate")[0].value ,
            'type': 'product'
        };
        ajax(rateUrl , params , json=>{
            if(json.status = 'success'){
                $(".comment-list")[0].innerHTML +=`
                <li class="comment">   
                    <div class="comment-body">
                        <div class="single-comment">
                            <div class="comment-img">
                                <img src="${json.comment.user.image}" class="w-70p r-1-1"
                                    alt="Author Images">
                            </div>
                            <div class="comment-inner">
                                <h6 class="commenter">
                                    <a class="hover-flip-item-wrapper">
                                        <span class="hover-flip-item">
                                            <span data-text="Cameron Williamson">${json.comment.user.name}</span>
                                        </span>
                                    </a>
                                    <span class="commenter-rating ratiing-four-star">
                                        <a><i class="fas fa-star ${json.comment.rate < 1 ? 'empty-rating' : ''}"></i></a>
                                        <a><i class="fas fa-star ${json.comment.rate < 2 ? 'empty-rating' : ''}"></i></a>
                                        <a><i class="fas fa-star ${json.comment.rate < 3 ? 'empty-rating' : ''}"></i></a>
                                        <a><i class="fas fa-star ${json.comment.rate < 4 ? 'empty-rating' : ''}"></i></a>
                                        <a><i
                                                class="fas fa-star ${json.comment.rate < 5 ? 'empty-rating' : ''}"></i></a>
                                    </span>
                                </h6>
                                <div class="comment-text">
                                    <p>${json.comment.body}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                `;
                newRate = 0;
                $("#bodyRate")[0].value = '';
                $("#bodyRate")[0].classList.remove('border' , 'border-danger')
            }
        } , "POST")
    }
}