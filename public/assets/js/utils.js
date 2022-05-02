function formatPrice(price) {
    return price.toLocaleString("it-IT", {
        style: "currency",
        currency: "VND",
    });
}

function loading(isOn) {
    var loadingEle = document.querySelector(".preloader");
    if (isOn) {
        loadingEle.style.display = "block";
        loadingEle.classList.add("ajax-loader");
    } else {
        loadingEle.style.display = "none";
        loadingEle.classList.remove("ajax-loader");
    }
}
