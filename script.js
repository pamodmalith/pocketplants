function signup() {

    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var email = document.getElementById("email");
    var password = document.getElementById("password");

    var form = new FormData();
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("mobile", mobile.value);
    form.append("email", email.value);
    form.append("password", password.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                window.location.reload();
                window.location = "login.php";
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "signup-process.php", true);
    req.send(form);
}

function login() {

    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var rememberMe = document.getElementById("rem");

    var form = new FormData();
    form.append("email", email.value);
    form.append("password", password.value);
    form.append("rememberMe", rememberMe.checked);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                window.location = "index.php";
            } else {
                showToast(resp, "warning");
            }
        }
    }

    req.open("POST", "login-process.php", true);
    req.send(form);
}

function forgotPassword() {

    var email = document.getElementById("email");

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "msgsent") {
                document.getElementById("emailsend").innerHTML = '<h3 class="fw-normal  text-center m-0">We have send a email associated with instructions to recover your password.</h3><p class="text-center mt-2"><a href="index.php" class="btn btn-success">Continue</a></p>';
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("GET", "forgot-password-process.php?email=" + email.value, true);
    req.send();

}

function resetPassword() {

    var email = document.getElementById("email")
    var pw = document.getElementById("pw");
    var cpw = document.getElementById("cpw");
    var vcode = document.getElementById("vcode");

    var form = new FormData();
    form.append("email", email.value);
    form.append("pw", pw.value);
    form.append("cpw", cpw.value);
    form.append("vcode", vcode.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                showAlert("Success", "Password Update Successfull", "success").then(() => (window.location = "login.php"));
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "reset-password-process.php", true);
    req.send(form);
}

function showAlert(title, text, icon) {
    return swal.fire({
        title: title,
        text: text,
        icon: icon
    });
}

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

function showToast(title, icon) {
    return Toast.fire({
        icon: icon,
        title: title
    });
}

function adminLogin() {

    var email = document.getElementById("email");
    var password = document.getElementById("password");

    var form = new FormData();
    form.append("email", email.value);
    form.append("password", password.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            resp = req.responseText;
            if (resp == "success") {
                window.location = "admin-dashboard.php";
            } else {
                showToast(resp, "warning");
            }
        }
    }

    req.open("POST", "admin-login-process.php", true);
    req.send(form);
}



function collapse() {
    document.querySelector("#sidebar").classList.toggle("collapsed");
};

function chart() {

    const chart = document.getElementById('chart');

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;                        
            var json = JSON.parse(resp); 
            console.log(json);
                       

            const data = {
                labels: json.dates,
                datasets: [
                    {
                        label: 'Sales',
                        data: json.sales,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Revenue',
                        data: json.revenues,
                        yAxisID: 'y',
                    }
                ]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',

                            // grid line settings
                            grid: {
                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                        },
                    }
                },
            };

            new Chart(chart, config);

        }
    }
    req.open("GET", "load-chart-process.php", true);
    req.send();
}

function loadUsers(page) {

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            document.getElementById("content").innerHTML = resp;
        }
    }
    req.open("GET", "load-users-process.php?page=" + page, true);
    req.send();

}

function changeUser(id, status, page) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.status == 200 && req.readyState == 4) {
            var resp = req.responseText;
            if (resp == "success") {
                loadUsers(page);
            } else {
                alert(resp);
            }
        }
    }
    req.open("GET", "change-user-status-process.php?id=" + id + "&s=" + status, true);
    req.send();
}

function valueLessError(id, msg) {
    var val = document.getElementById(id);

    if (val.value < 1) {
        val.value = null;
        showToast(msg, "warning");
    }

}

function addNewCat() {

    var newName = document.getElementById('newCategoryName');

    var form = new FormData();
    form.append("cat", newName.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                showAlert("successfully added", "", "success").then(() => window.location.reload());
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "register-cat-process.php", true);
    req.send(form);

}

function addNewColor() {

    var newName = document.getElementById('newColorName');

    var form = new FormData();
    form.append("color", newName.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                showAlert("successfully added", "", "success").then(() => window.location.reload());
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "register-color-process.php", true);
    req.send(form);

}

function addNewSize() {

    var newName = document.getElementById('newSizeName');

    var form = new FormData();
    form.append("size", newName.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                showAlert("successfully added", "", "success").then(() => window.location.reload());
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "register-size-process.php", true);
    req.send(form);

}

function previewImg() {

    var images = document.getElementById('productImage');

    images.onchange = function () {
        var url = window.URL.createObjectURL(images.files[0]);
        document.getElementById("preview").classList.remove("d-none");
        document.getElementById("i").src = url;
    }
}


function registerProduct() {

    var name = document.getElementById("productName");
    var category = document.getElementById("productCategory");
    var size = document.getElementById("productSize");
    var desc = document.getElementById("productDescription");
    var productCost = document.getElementById("productCost");
    var sellingPrice = document.getElementById("productPrice");
    var color = document.getElementById("productColor");
    var image = document.getElementById("productImage");

    var form = new FormData();
    form.append("name", name.value);
    form.append("category", category.value);
    form.append("size", size.value);
    form.append("desc", desc.value);
    form.append("productCost", productCost.value);
    form.append("sellPrice", sellingPrice.value);
    form.append("color", color.value);
    form.append("img", image.files[0]);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                showAlert("Product added successfully", "", "success").then(() => window.location.reload());
            } else {
                showToast(resp, "warning");
            }
        }
    }

    req.open("POST", "register-product-process.php", true);
    req.send(form);

}

function loadProducts(page) {

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            resp = req.responseText;
            document.getElementById("content").innerHTML = resp;
        }
    }

    req.open("GET", "load-product-process.php?page=" + page, true);
    req.send();

}

function changeProductStatus(id, page) {

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;

            if (resp == "activated") {
                loadProducts(page);
                // showToast("Activated", "success");
            } else if (resp == "deactivated") {
                loadProducts(page);
                // showToast("Deactivated", "success");
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("GET", "change-product-status-process.php?id=" + id, true);
    req.send();
}

function searchProducts(page) {

    var keyword = document.getElementById("productSearch").value;

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            resp = req.responseText;
            document.getElementById("content").innerHTML = resp;
        }
    }

    req.open("GET", "admin-search-product-process.php?page=" + page + "&keyword=" + keyword, true);
    req.send();

}

function updateProdModalOpen(id) {

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            var data = JSON.parse(resp);

            document.getElementById("uId").value = data.id;
            document.getElementById("uName").value = data.name;
            document.getElementById("uCat").value = data.cat_id;
            document.getElementById("uSize").value = data.size_id;
            document.getElementById("uDes").value = data.description;
            document.getElementById("uCost").value = data.cost;
            document.getElementById("uPrice").value = data.price;
            document.getElementById("uColor").value = data.color_id;
            document.getElementById("img").src = data.img;

            new bootstrap.Modal(document.getElementById("editProductModal")).show();
        }
    }
    req.open("GET", "get-product-details.php?id=" + id, true);
    req.send();
}

function uPreviewImg() {

    var images = document.getElementById('uImg');

    images.onchange = function () {
        var url = window.URL.createObjectURL(images.files[0]);
        document.getElementById("img").src = url;
    }
}

function updateProduct() {
    var id = document.getElementById("uId");
    var name = document.getElementById("uName");
    var cat = document.getElementById("uCat");
    var size = document.getElementById("uSize");
    var desc = document.getElementById("uDes");
    var cost = document.getElementById("uCost");
    var price = document.getElementById("uPrice");
    var color = document.getElementById("uColor");
    var image = document.getElementById("uImg");

    var form = new FormData();
    form.append("id", id.value);
    form.append("name", name.value);
    form.append("cat", cat.value);
    form.append("size", size.value);
    form.append("desc", desc.value);
    form.append("cost", cost.value);
    form.append("price", price.value);
    form.append("color", color.value);
    form.append("img", image.files[0]);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            console.log(resp);
            if (resp == "success") {
                showAlert("Success", "Product Update Successfully", "success").then(() => (window.location.reload()));
            } else {
                showToast(resp, "warning")
            }
        }
    }
    req.open("POST", "update-product-process.php", true);
    req.send(form);
}

function changeImgStock() {

    var product = document.getElementById("product");
    var div = document.getElementById("stockImgDiv");
    var img = document.getElementById("stockImg");

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            var data = JSON.parse(resp);
            console.log(data);
            div.classList.remove("d-none");
            img.src = data.img;
        }
    }
    req.open("GET", "get-product-details.php?id=" + product.value, true);
    req.send();
}

function loadStocks(page) {

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            resp = req.responseText;
            document.getElementById("content").innerHTML = resp;
        }
    }

    req.open("GET", "load-stock-process.php?page=" + page, true);
    req.send();

}

function addNewStock() {

    var product = document.getElementById("product");
    var qty = document.getElementById("qty");

    var form = new FormData();
    form.append("product", product.value);
    form.append("qty", qty.value);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            console.log(resp);
            if (resp == "success") {
                showAlert("Success", "Stock Updated Successfully!", "success").then(() => (window.location.reload()));
            } else {
                showAlert("Error", resp, "error");
            }
        }
    }
    req.open("POST", "add-stock-process.php", true);
    req.send(form);
}

function changeStockStatus(stockId, page) {

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;

            if (resp == "activated") {
                loadStocks(page);
            } else if (resp == "deactivated") {
                loadStocks(page);
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("GET", "change-stock-status-process.php?id=" + stockId, true);
    req.send();
}

function addToCart(stock, stockQty) {

    var qty;
    var element = document.getElementById("qty");
    if (element) {
        qty = element.value;
    } else {
        qty = 1;
    }
    if (stockQty < 1) {
        showToast("Quantity Exceeded", "warning");
    } else {
        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (req.readyState == 4 && req.status == 200) {
                var resp = req.responseText;
                if (resp == "success") {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-close-white"
                        }
                    });
                    swalWithBootstrapButtons.fire({
                        title: "Add To cart Succesfull",
                        text: "Continue shopping or go to cart?",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonText: "Go to cart!",
                        cancelButtonText: "Continue shopping",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "cart.php";
                        }
                    });
                } else {
                    showAlert(resp, "", "warning");
                }

            }
        }
        req.open("GET", "add-to-cart-process.php?stock=" + stock + "&qty=" + qty, true);
        req.send();
    }
}

function loadCart() {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            document.getElementById("content").innerHTML = resp
        }
    }
    req.open("GET", "load-cart-process.php", true);
    req.send();
}

function removeFromCart(cartId) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
    });
    swalWithBootstrapButtons.fire({
        title: "Remove from cart?",
        text: "Are you sure you want to delete this item?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    var resp = req.responseText;
                    if (resp == "success") {
                        showAlert("Success", "Cart Item Removed Successfully!", "success").then(loadCart);

                    } else {
                        showAlert("Error", resp, "error");
                    }
                }
            }
            req.open("GET", "remove-from-cart-process.php?id=" + cartId, true);
            req.send();

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "",
                icon: "error"
            });
        }
    });

}

function incrementCartQty(cartId) {

    var qty = document.getElementById("qty-" + cartId);
    var newQty = parseInt(qty.value) + 1;

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                loadCart();
            } else {
                showAlert(resp, "", "error");
            }
        }
    }
    req.open("GET", "update-cart-qty-process.php?id=" + cartId + "&qty=" + newQty, true);
    req.send();
}

function decrementCartQty(cartId) {

    var qtyE = document.getElementById("qty-" + cartId);
    var qty = parseInt(qtyE.value);

    if (qty <= 1) {
        showAlert("Quantity must be at least 1", "", "warning");
    } else {
        var newQty = qty - 1;

        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (req.readyState == 4 && req.status == 200) {
                var resp = req.responseText;
                if (resp == "success") {
                    loadCart();
                } else {
                    showAlert("Error", resp, "error");
                }
            }
        }
        req.open("GET", "update-cart-qty-process.php?id=" + cartId + "&qty=" + newQty, true);
        req.send();
    }
}

function printReport() {

    var original = document.body.innerHTML;
    var printArea = document.getElementById("printArea");
    var heading = document.getElementById("heading");

    document.body.innerHTML = heading.innerHTML + printArea.innerHTML;

    window.print();

    document.body.innerHTML = original;
}

function exportToPdf(fileName) {

    var element = document.getElementById('printArea');
    html2pdf().from(element).save(fileName);
}

function search(page) {

    var search = document.getElementById("search");
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            document.getElementById("content").innerHTML = resp;
        }
    }
    req.open("GET", "search-products-process.php?search=" + search.value + "&page=" + page, true);
    req.send();
}

function filter(page) {
    var category = document.getElementById("cat");
    var size = document.getElementById("size");
    var color = document.getElementById("color");
    var priceFrom = document.getElementById("priceFrom");
    var priceTo = document.getElementById("priceTo");
    var search = document.getElementById("search");

    var form = new FormData();
    form.append("category", category.value);
    form.append("size", size.value);
    form.append("color", color.value);
    form.append("priceFrom", priceFrom.value);
    form.append("priceTo", priceTo.value);
    form.append("search", search.value);
    form.append("page", page);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            document.getElementById("allContent").innerHTML = resp;
        }
    }
    req.open("POST", "filter-product-process.php", true);
    req.send(form);
}

function updatePersonalData() {
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var mobile = document.getElementById("mobile").value;

    var form = new FormData();
    form.append("fname", fname);
    form.append("lname", lname);
    form.append("mobile", mobile);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            console.log(resp);
            if (resp == "success") {
                showAlert("Update Success", "", "success").then(() => window.location.reload());
            } else {
                showToast(resp, "warning").onAfterClose(() => window.location.reload());
            }
        }
    }
    req.open("POST", "update-user-details-process.php", true);
    req.send(form);
}


function updateUserAddress() {
    var no = document.getElementById("no").value;
    var pcode = document.getElementById("postal").value;
    var province = document.getElementById("state").value;
    var city = document.getElementById("city").value;
    var street = document.getElementById("street").value;

    var form = new FormData();
    form.append("no", no);
    form.append("pcode", pcode);
    form.append("province", province);
    form.append("city", city);
    form.append("street", street);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            console.log(resp);
            if (resp == "success") {
                showAlert("Update Success", "", "success").then(() => window.location.reload());
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "update-user-address-process.php", true);
    req.send(form);
}

function previewProfile() {

    var images = document.getElementById('profileImg');

    images.onchange = function () {
        var url = window.URL.createObjectURL(images.files[0]);
        document.getElementById("profileImgTag").src = url;
    }
}

function updateProfileImg() {

    var profileImg = document.getElementById("profileImg");

    var form = new FormData();
    form.append("img", profileImg.files[0]);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;

            if (resp == "success") {
                window.location.reload();
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("POST", "upload-profile-img-process.php", true);
    req.send(form);
}

function qty_inc(qty) {

    var input = document.getElementById("qty");

    if (input.value < qty) {

        var new_value = parseInt(input.value) + 1;
        input.value = new_value;

    } else {

        showToast("You have reached to the Maximum", "warning");
        input.value = qty;

    }

}

function qty_dec() {

    var input = document.getElementById("qty");

    if (input.value > 1) {

        var new_value = parseInt(input.value) - 1;
        input.value = new_value;

    } else {

        showToast("You have reached to the Minimum", "warning");
        input.value = 1;

    }

}

function check_value(qty) {

    var input = document.getElementById("qty");

    if (input.value < 1) {
        showToast("You Must add 1 or more", "warning");
        input.value = 1;
    } else if (input.value > qty) {
        showToast("Insufficient quantity", "warning");
        input.value = 1;
    }
}

function checkout() {

    var form = new FormData();
    form.append("cart", true);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var json = req.responseText;
            var resp = JSON.parse(json);
            if (resp.status == "success") {
                doCheckout(resp.payment, "checkout-process.php");
            } else {
                showAlert("Warning", resp.error, "warning");
            }
        }
    }
    req.open("POST", "payment-process.php", true);
    req.send(form);
}

function doCheckout(payment, url) {

    payhere.onCompleted = function onCompleted(orderId) {

        var form = new FormData();
        form.append("payment", JSON.stringify(payment));

        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (req.readyState == 4 && req.status == 200) {
                var json = req.responseText;
                console.log(json);

                var resp = JSON.parse(json);
                if (resp.status == "success") {
                    invoiceSend(resp.ohId);
                    showAlert("Order Success!", "OrderID: " + orderId, "success").then(() => {window.location.reload();});
                } else {
                    showAlert("Error", resp.error, "error");
                }
            }
        }
        req.open("POST", url, true);
        req.send(form);

    };

    payhere.onDismissed = function onDismissed() {
        showAlert("Warning", "Payment dismissed", "warning");
    };

    payhere.onError = function onError(error) {
        showAlert("Error", error, "error");
    };

    payhere.startPayment(payment);
}

function buyNow(stockId) {

    var qty = document.getElementById("qty");

    if (qty.value > 0) {

        var form = new FormData();
        form.append("cart", false);
        form.append("stockId", stockId);
        form.append("qty", qty.value);

        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (req.readyState == 4 && req.status == 200) {
                var json = req.responseText;
                console.log(json);
                
                var resp = JSON.parse(json);

                if (resp.status == "success") {
                    resp.payment.stock_id = stockId;
                    resp.payment.qty = qty.value;
                    doCheckout(resp.payment, "buy-now-process.php");
                } else {
                    showAlert("Warning", resp.error, "warning");
                }
            }
        }
        req.open("POST", "payment-process.php", true);
        req.send(form);

    } else {
        showAlert("Warning", "Quantity cannot be less than 1", "warning");
    }
}

function printInvoice() {

    var original = document.body.innerHTML;
    var printArea = document.getElementById("printArea");

    document.body.innerHTML = printArea.innerHTML;

    window.print();

    document.body.innerHTML = original;
}

function invoiceSend(ohId) {

    var form = new FormData();
    form.append("ohId", ohId);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            mailInvoice(resp, ohId);
        }
    }
    req.open("POST", "invoice-getting-process.php", true);
    req.send(form);
}

function mailInvoice(mailbody, ohId) {

    var form = new FormData();
    form.append("mailbody", mailbody);
    form.append("ohId", ohId);

    var req = new XMLHttpRequest();
    req.open("POST", "invoice-mailing-process.php", true);
    req.send(form);
}

function loadOrderHistory() {

    var filter = document.getElementById("filterOrders").value;
    limit = 0;

    if (filter == 0) {
        limit = 5;
    } else if (filter == 1) {
        limit = 15;
    }

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            document.getElementById("content").innerHTML = resp;
        }
    }
    req.open("GET", "get-order-history-process.php?limit=" + limit, true);
    req.send();
}

function addToWishlist(id) {

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "added") {
                location.reload();
            } else if (resp == "remove") {
                location.reload();
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("GET", "add-to-wishlist-process.php?id=" + id, true);
    req.send();
}

function removeFromWishlist(id) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var resp = req.responseText;
            if (resp == "success") {
                location.reload();
            } else {
                showToast(resp, "warning");
            }
        }
    }
    req.open("GET", "remove-from-wishlist-process.php?id=" + id, true);
    req.send();
}
