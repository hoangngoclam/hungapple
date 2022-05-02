var addToCartBtns = document.querySelectorAll("a[data-type='addToCartBtn']");
var rmFromCartBtns = document.querySelectorAll("a[data-type='rmFromCartBtn']");
var plusCartItemBtns = document.querySelectorAll(
    "input[data-type='plusCartItemBtn']"
);
var minusCartItemBtns = document.querySelectorAll(
    "input[data-type='minusCartItemBtn']"
);

// START Handle add to cart
for (const btn of addToCartBtns) {
    btn.addEventListener("click", function () {
        addToCart(btn.dataset.id);
    });
}
// END Handle add to cart

// START Handle remove from cart
for (const btn of rmFromCartBtns) {
    btn.addEventListener("click", function () {
        removeFromCart(btn.dataset.rowid);
    });
}
// END Handle remove from cart

// START Handle update quantity
for (const btn of plusCartItemBtns) {
    btn.addEventListener("click", function () {
        var rowId = btn.dataset.rowid;
        var currentQty = document.querySelector(
            `input[name="quantity"][data-rowid="${rowId}"]`
        ).value;
        updateCartQuantity(rowId, parseInt(currentQty) + 1);
    });
}

for (const btn of minusCartItemBtns) {
    btn.addEventListener("click", function () {
        var rowId = btn.dataset.rowid;
        var currentQty = document.querySelector(
            `input[name="quantity"][data-rowid="${rowId}"]`
        ).value;
        updateCartQuantity(rowId, parseInt(currentQty) - 1);
    });
}
// END Handle update quantity

function addToCart(id, qty = 1) {
    if (id) {
        loading(true);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        });
        $.ajax({
            type: "POST",
            url: addToCartUrl,
            data: { id, qty },
            cache: false,
            success: function (response) {
                var { status, cartList, totalQty, totalPrice, tax } = response;
                var cartListObject = JSON.parse(cartList);
                var totalPrice = parseFloat(totalPrice);
                if (
                    status == SUCCESS_STATUS &&
                    !jQuery.isEmptyObject(cartListObject) &&
                    totalPrice
                ) {
                    if (status == SUCCESS_STATUS) {
                        swal({
                            title: "Thành công",
                            text: "Đã thêm vào giỏ hàng!",
                            icon: "success",
                            buttons: {
                                cancel: "Trở về",
                                cart: "Đến giỏ hàng",
                            },
                        }).then((value) => {
                            switch (value) {
                                case "cart":
                                    window.location.href = cartUrl;
                                    break;
                            }
                        });
                        if (!jQuery.isEmptyObject(cartListObject)) {
                            renderCartList(
                                cartListObject,
                                totalQty,
                                totalPrice,
                                tax
                            );
                        } else {
                            renderEmptyCart(cartListObject);
                        }
                    }
                }
            },
            error: function () {
                swal({
                    title: "Thất bại",
                    text: "Lỗi khi thêm vào giỏ hàng!",
                    icon: "error",
                    button: "Tiếp tục",
                });
            },
            complete: function () {
                loading(false);
            },
        });
    }
}

function addToCartQuickView(id) {
    var qty = document.querySelector(`#quantity-quickview-${id}`).value;
    addToCart(id, qty);
}

function removeFromCart(rowId) {
    if (rowId) {
        loading(true);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        });
        $.ajax({
            type: "POST",
            url: rmFromCartUrl,
            data: { rowId },
            cache: false,
            success: function (response) {
                var { status, cartList, totalQty, totalPrice, tax } = response;
                var cartListObject = JSON.parse(cartList);
                if (status == SUCCESS_STATUS) {
                    swal({
                        title: "Thành công!",
                        text: "Đã xóa sản phẩm khỏi giỏ hàng!",
                        icon: "success",
                        button: "Tiếp tục!",
                    });
                    if (!jQuery.isEmptyObject(cartListObject)) {
                        renderCartList(
                            cartListObject,
                            totalQty,
                            totalPrice,
                            tax
                        );
                    } else {
                        renderEmptyCart(cartListObject);
                    }
                }
            },
            error: function () {
                swal({
                    title: "Thất bại",
                    text: "Lỗi khi thêm vào giỏ hàng!",
                    icon: "error",
                    button: "Tiếp tục",
                });
            },
            complete: function () {
                loading(false);
            },
        });
    }
}

function updateCartQuantity(rowId, qty) {
    if (rowId && qty) {
        loading(true);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        });
        $.ajax({
            type: "POST",
            url: updateCartQtyUrl,
            data: { rowId, qty },
            cache: false,
            success: function (response) {
                var { status, cartList, totalQty, totalPrice, tax } = response;
                var cartListObject = JSON.parse(cartList);
                if (status == SUCCESS_STATUS) {
                    swal({
                        title: "Thành công!",
                        text: "Đã xóa sản phẩm khỏi giỏ hàng!",
                        icon: "success",
                        button: "Tiếp tục!",
                    });
                    if (!jQuery.isEmptyObject(cartListObject)) {
                        renderCartList(
                            cartListObject,
                            totalQty,
                            totalPrice,
                            tax
                        );
                    } else {
                        renderEmptyCart(cartListObject);
                    }
                }
            },
            error: function () {
                swal({
                    title: "Thất bại",
                    text: "Lỗi khi thêm vào giỏ hàng!",
                    icon: "error",
                    button: "Tiếp tục",
                });
            },
            complete: function () {
                loading(false);
            },
        });
    }
}

function renderCartList(cartList, totalQty, price, tax) {
    var cartDropDownElement = document.querySelector("li.cart_dropdown");
    var cartDropDownHtml = `<a class="nav-link cart_trigger" href="#" data-toggle="dropdown" aria-expanded="true">
    <i class="linearicons-cart"></i><span class="cart_count">${totalQty}</span>
</a><div class="cart_box dropdown-menu dropdown-menu-right"><ul class="cart_list">`;
    for (const key in cartList) {
        if (cartList.hasOwnProperty(key)) {
            var cartItem = cartList[key];
            var cartItemHtml = `<li>
        <a data-rowid="${
            cartItem.rowId
        }" href="javascript:void(0)" onclick="removeFromCart('${
                cartItem.rowId
            }');" class="item_remove"><i class="ion-close"></i></a>
        <a href="#"><img src="${cartItem.options.img}" alt="cart_thumb1" onerror="this.onerror=null;this.src='${imageNotFoundUrl}';">${
                cartItem.name
            }</a>
        <span class="cart_quantity"> ${
            cartItem.qty
        } x <span class="cart_amount"> <span class="price_symbole"></span></span>${formatPrice(
                cartItem.price
            )}</span>
    </li>`;
            cartDropDownHtml += cartItemHtml;
        }
    }
    cartDropDownHtml += `</ul>`;
    cartDropDownHtml += `<div class="cart_footer">
    <p class="cart_total"><strong>Tổng giá:</strong> <span class="cart_price">${formatPrice(
        price
    )}<span class="price_symbole"></span></span></p>
    <p class="cart_buttons"><a href="${cartUrl}" class="btn btn-fill-line view-cart">Giỏ hàng</a>
    <a href="${checkoutUrl}" class="btn btn-fill-out checkout">Thanh toán</a>
    </p>
</div></div>`;
    cartDropDownElement.innerHTML = cartDropDownHtml;
    if (isCartPage) {
        var cartTableElement = document.querySelector(".shop_cart_table tbody");
        var cartTableHtml = "";
        for (const key in cartList) {
            if (cartList.hasOwnProperty(key)) {
                var cartItem = cartList[key];
                var cartItemHtml = `<tr>
            <td class="product-thumbnail"><a href="#"><img src="${
                cartItem.options.img
            }" alt="${cartItem.name}" onerror="this.onerror=null;this.src='${imageNotFoundUrl}';"></a></td>
            <td class="product-name" data-title="Product"><a href="#">${
                cartItem.name
            }</a></td>
            <td class="product-price" data-title="Price">${formatPrice(
                cartItem.price
            )}</td>
            <td class="product-quantity" data-title="Quantity">
                <div class="quantity">
                    <input type="button" value="-" class="minus" data-type="minusCartItemBtn" data-rowid="${
                        cartItem.rowId
                    }" onclick="updateCartQuantity('${cartItem.rowId}',${
                    parseInt(cartItem.qty) - 1
                });">
                    <input type="text" name="quantity" value="${
                        cartItem.qty
                    }" title="Qty" class="qty" size="4" data-rowid="${
                    cartItem.rowId
                }">
                    <input type="button" value="+" class="plus" data-type="plusCartItemBtn" data-rowid="${
                        cartItem.rowId
                    }" onclick="updateCartQuantity('${cartItem.rowId}',${
                    parseInt(cartItem.qty) + 1
                });">
                </div>
            </td>
            <td class="product-subtotal" data-title="Total">${formatPrice(
                cartItem.price * cartItem.qty
            )}</td>
            <td class="product-remove" data-title="Remove"><a href="javascript:void(0)" data-rowid="${
                cartItem.rowId
            }" data-type="rmFromCartBtn" onclick="removeFromCart('${
                    cartItem.rowId
                }');"><i class="ti-close"></i></a></td>
        </tr>`;
                cartTableHtml += cartItemHtml;
            }
        }
        cartTableElement.innerHTML = cartTableHtml;
        var cartTotalElements = document.querySelectorAll(".cart_total_amount");
        cartTotalElements[0].innerHTML = formatPrice(price);
        cartTotalElements[1].innerHTML = formatPrice(tax);
        cartTotalElements[2].innerHTML = formatPrice(price + tax);
    }
}

function renderEmptyCart() {
    var cartDropDownElement = document.querySelector("li.cart_dropdown");
    cartDropDownElement.innerHTML = `<a class="nav-link cart_trigger" href="#" data-toggle="dropdown">
    <i class="linearicons-cart"></i><span class="cart_count">0</span>
</a>
<div class="cart_box dropdown-menu dropdown-menu-right"><div class="cart-empty cart-empty-list"><i class="linearicons-cart-empty"></i>
<div>Giỏ hàng của bạn hiện đang trống</div>
</div></div>`;
    if (isCartPage) {
        var cartContainerElement = document.querySelector("#cartContainer");
        cartContainerElement.innerHTML = ` <div class="cart-empty"><i class="linearicons-cart-empty"></i>
    <div>Giỏ hàng của bạn hiện đang trống</div>
    <a href="${shopUrl}" class="btn btn-fill-out">Đến cửa hàng</a>
</div>`;
    }
}
