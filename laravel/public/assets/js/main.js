// function $(selector, type = null) {
//   let element;
//   if (type == "id") element = document.getElementById(selector);
//   else if (type == "all") element = document.querySelectorAll(selector);
//   else element = document.querySelector(selector);
//   return element;
// }

//ajax
function ajax(
    url,
    params = {},
    callback,
    httpType = "POST",
    callbackErr = () => {},
    contentType = "application/json"
) {
    var xhr = new XMLHttpRequest();
    xhr.open(httpType, url, true);
    xhr.setRequestHeader("Content-Type", contentType);
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let json = JSON.parse(xhr.responseText);
            callback(json);
        }
    };
    params = JSON.stringify(params);
    xhr.send(params);
}

//loading
function loading() {
    let loading = $(".loading", "all");
    let img = document.createElement("img");
    img.setAttribute("src", "/assets/images/icons/loading.svg");
    for (let i = 0; i < loading.length; i++) {
        loading[i].appendChild(img);
    }
}
loading();

let mainUrl = "http://127.0.0.1:8000/api";

function setNumberCart(el){
    console.log(el)
}


let cartUrl = `${mainUrl}/getCart`;
let cart_items = "";
let cart_footer =""
function getCart()
 {
    cart_items = "";
    ajax(
        cartUrl,
        {},
        (json) => {
            if (json.status == "success") {
                if (json.products.length > 0) {
                    json.products.forEach((p) => {
                        cart_items += `
                        <li class="cart-item">
                            <div class="item-img">
                                <a href="/product/${p.slug}"><img src="${
                            p.images[0]
                        }"
                                        alt="${p.name}"></a>
                                <button class="close-btn" onclick="deleteCartItem(${
                                    p.cart_id
                                })"><i class="fas fa-times"></i></button>
                            </div>
                            <div class="item-content">
                                <div class="product-rating">
                                    <span class="icon">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="rating-number">(64)</span>
                                </div>
                                <h3 class="item-title"><a href="/product/${
                                    p.slug
                                }">${p.name}</a></h3>
                                <div class="">
                                    <span class="price text-black fs-1 text-bold sd">${
                                        p.newPrice
                                    }</span>
                                    ${
                                        p.newPrice != p.price
                                            ? `
                                        <span
                                            class="price old-price text-decoration-middle ms-3 fs-3 sd">${p.price}</span>
                                            
                                  `
                                            : ""
                                    }
                                </div>
                                <div>
                                    <span class="me-2">سایز </span>
                                    <span>${p.size}</span>
                                </div>
                                <div class="pro-qty pro-qtyCart item-quantity">
                                    <input type="number" class="quantity-input" onchange="setNumberCart(this)" value="${
                                        p.number
                                    }">
                                </div>
                            </div>
                        </li>
                      `;
                    });
                    cart_footer = `
                    <h3 class="cart-subtotal">
                        <span class="subtotal-title">مجموع:</span>
                        <span class="subtotal-amount price">${json.subTotal} تومان</span>
                    </h3>
                    <div class="group-btn">
                        <a href="/cart" class="axil-btn btn-bg-primary viewcart-btn">نمایش سبد خرید</a>
                        <a href="checkout.html" class="axil-btn btn-bg-secondary checkout-btn">پرداخت</a>
                    </div>
                    `;
                    
            $(".cart-count")[0].textContent = json.products.length;
                }else{
                  cart_items = 'سبد خرید خالی است'
                }
            } else if (json.status == "login") {
                cart_items = '<span>ابتدا وارد حساب خود شوید  </span><a href="/login" class="text-info">ورود</a>';
            }
            $("#cart-item-list")[0].innerHTML = cart_items;
            $("#cart-footer")[0].innerHTML = cart_footer;
            let price = $(".price");
            for (let i = 0; i < price.length; i++) {
                price[i].innerHTML = price[i].textContent
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            $(".pro-qtyCart").prepend('<span class="dec qtybtn qtybtnCart">-</span>');
            $(".pro-qtyCart").append('<span class="inc qtybtn qtybtnCart">+</span>');
            $(".qtybtnCart").on("click", function () {
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
                setNumberCart(newVal);
                $button.parent().find("input").val(newVal);
            });
        },
        "POST"
    );
}
getCart();
function deleteCartItem(id , item=null){
    let deleteCartUrl = `${mainUrl}/deleteCart?id=${id}`;
    ajax(deleteCartUrl , {} , json=>{
        if(json.status == 'success'){
            getCart();
            if(item){
                $(`#cart-row${id}`)[0].remove();
            }
        }
    } , "POST")
}
function getCategories(){
    let categoriesUrl = `${mainUrl}/getCategories`;
    let categories = '';
    ajax(categoriesUrl , {} , json=>{
        json.categories.forEach(c=>{
            categories +=`
                <li><a href="/products?cat=${c.id}">${c.name}</a></li>
            `;
        });
        $("#header-categories")[0].innerHTML = categories;
    }, "GET");
}
getCategories();



let price = $(".price");
let d = "";
for (let i = 0; i < price.length; i++) {
    d = price[i].textContent.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    price[i].textContent = price[i].textContent
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


function searchProduct(el){
    let searchUrl = `${mainUrl}/searchProduct?search=${el.value}`;
    let searchCon = '';
    let searchItem = '';
    ajax(searchUrl , {} , json=>{
        json.products.data.forEach(p=>{
            searchItem +=`
            <div class="axil-product-list">
            <div class="thumbnail">
                <a href="/product/${p.slug}">
                    <img src="${p.images[0]}" alt="${p.name}" class="w-100p r-1-1">
                </a>
            </div>
            <div class="product-content">
                <div class="product-rating">
                    <span class="rating-icon">
                        <i class="${p.rate < 1 ? 'fal' : 'fas'} fa-star"></i>
                        <i class="${p.rate < 2 ? 'fal' : 'fas'} fa-star"></i>
                        <i class="${p.rate < 3 ? 'fal' : 'fas'} fa-star"></i>
                        <i class="${p.rate < 4 ? 'fal' : 'fas'} fa-star"></i>
                        <i class="${p.rate < 5 ? 'fal' : 'fas'} fa-star"></i>
                    </span>
                    <!-- <span class="rating-number"><span>100+</span> Reviews</span> -->
                </div>
                <h6 class="product-title"><a href="/product/${p.slug}">${p.name}</a></h6>
                <div class="product-price-variant">
                    <span class="price current-price">${p.newPrice} تومان</span>
                    ${p.newPrice != p.price ? `<span class="price old-price">${p.price} تومان</span>` : ''}
                </div>
                <div class="product-cart">
                    ${p.amount != 0 ? `<a data-bs-target="#quick-choose" data-bs-toggle="modal"  onclick="openSizeModal(${p.id})" class="cart-btn"><i class="fal fa-shopping-cart"></i></a>`:`<a class="cart-btn"><i class="fal fa-shopping-cart  text-secondary"></i></a>`}
                    <a onclick="addWish(this , ${p.id})" class="cart-btn ${p.wish == 1 ? 'wishShow' : ''}"><i class="fal fa-heart"></i></a>
                </div>
            </div>
        </div>
            `;
        });
        searchCon = `
        <div class="search-result-header">
            <h6 class="title">${json.products.total} نتیجه یافت شد</h6>
            <a href="/products?search=${el.value}" class="view-all">نمایش همه</a>
        </div>
        <div class="psearch-results">
            ${searchItem}
            
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
        `;
        // console.log(json.products.length)
        $("#searchModalItems")[0].innerHTML = searchCon;
    },  "GET")
}

