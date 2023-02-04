let price = document.getElementsByClassName("price");
let d = "";
for (let i = 0; i < price.length; i++) {
    d = price[i].textContent.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    price[i].textContent = d;
}
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
                    el.textContent = "افزوده شد";
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
