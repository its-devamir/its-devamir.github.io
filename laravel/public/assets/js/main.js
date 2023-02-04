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
function loading(){
let loading = $(".loading" , "all");
let img = document.createElement("img");
img.setAttribute("src" , '/assets/images/icons/loading.svg');
for(let i =0; i< loading.length; i++){
loading[i].appendChild(img);
}}
loading();

let mainUrl = 'http://127.0.0.1:8000/api';