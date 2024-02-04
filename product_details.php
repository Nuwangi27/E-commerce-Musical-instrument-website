<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - RedStore</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="images/web-logo.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="menuItems">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Product</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Conatact</a></li>
                        <li><a href="account.php">Log In</a></li>
                    </ul>
                </nav>
                <a href="cart.php"><img src="images/cart.png" width="30px" height="30px"></a>
                <div class="noti_cart_number">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];

                        $ip = get_ip();

                        $run_items = mysqli_query($con, "select * from cart where ip_address='$ip' and user_id='$user_id'");

                        echo $count_items = mysqli_num_rows($run_items);
                    }
                    ?>
                </div>

                <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    $run_query_by_id = mysqli_query($con, "select * from users where id = '$user_id'");
                    while ($row_user = mysqli_fetch_array($run_query_by_id)) {
                        $user_img = $row_user['image'];
                    }
                    echo "
                    <div class='profile'>
                    <a href='user/user_profile.php'><img src='upload-files/$user_img'></a>   
                    </div>
                        
                    ";
                } else {
                    echo "
                    <div class='profile'>
                    <a href='account.php'><img src='images/profile-1.png'></a>   
                    </div>   
                    ";
                }

                ?>

                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>

    <!-------- single product details-------->


    <div class="small-container single-product">
        <div class="row">
        
            <?php
            if (isset($_GET['pro_id'])) {
                $product_id = $_GET['pro_id'];

                $run_query_by_pro_id = mysqli_query($con, "select * from products where product_id = '$product_id'");

                while ($row_pro = mysqli_fetch_array($run_query_by_pro_id)) {

                    $pro_id = $row_pro['product_id'];
                    $pro_cat = $row_pro['product_cat'];
                    $pro_brand = $row_pro['product_brand'];
                    $pro_title = $row_pro['product_title'];
                    $pro_price = $row_pro['product_price'];
                    $pro_desc = $row_pro['product_desc'];
                    $pro_img_01 = $row_pro['product_img_01'];
                    $pro_img_02 = $row_pro['product_img_02'];
                    $pro_img_03 = $row_pro['product_img_03'];
                    $pro_img_04 = $row_pro['product_img_04'];
                    $pro_img_05 = $row_pro['product_img_05'];
                    $available_qty = $row_pro['product_qty'];

                    if ($available_qty > 0) {
                        echo "
                <div class='col-2-img'>
                <img src='admin/product_imgs/$pro_img_01' width='100%' id='productImg'>

                <div class='small-img-row'>
                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_02' width='100%' class='small-img'>
                    </div>

                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_03' width='100%' class='small-img'>
                    </div>

                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_04' width='100%' class='small-img'>
                    </div>

                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_05' width='100%' class='small-img'>
                    </div>
                </div>
            </div>
            <div class='col-2'>
                <p>Home / $pro_title</p>
                <h1>$pro_title</h1>
                <h4>Rs.$pro_price.00</h4>
                
                <div class='instock'>In Stock</div>
                <input id = 'pro_quantity' name = 'quantity' type='number' value='1' min='1'  max='$available_qty'>
                <button  class = 'add-btn' onclick = 'addToCart()'>Add to Cart</button>
                <br>
                <a href='ratings.php?pro_id=$product_id' class='rate'>Rate Product</a>
                <p id = 'product_id' style = 'display:none;'>$pro_id</p>
                <h3>Product Details <i class='fa fa-indent'></i></h3>
                <br>
                <p>$pro_desc</p>
            </div>
                ";






                    } else {
                        echo "
                <div class='col-2-img'>
                <img src='admin/product_imgs/$pro_img_01' width='100%' id='productImg'>

                <div class='small-img-row'>
                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_02' width='100%' class='small-img'>
                    </div>

                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_03' width='100%' class='small-img'>
                    </div>

                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_04' width='100%' class='small-img'>
                    </div>

                    <div class='small-img-col'>
                        <img src='admin/product_imgs/$pro_img_05' width='100%' class='small-img'>
                    </div>
                </div>
            </div>
            <div class='col-2'>
                <p>Home / $pro_title</p>
                <h1>$pro_title</h1>
                <h4>Rs.$pro_price.00</h4>
                
                <div class='outofstock'>Out Of Stock</div>
                <br>

                <input id = 'pro_quantity' name = 'quantity' type='number' value='1' min='1'  max='$available_qty'>
                <br>
                <a href='ratings.php?pro_id=$product_id' class='rate'>Rate Product</a>
                <button  class = 'disable-btn' disabled onclick = 'addToCart()'>Add to Cart</button>
                <p id = 'product_id' style = 'display:none;'>$pro_id</p>
                
                <h3>Product Details <i class='fa fa-indent'></i></h3>
                <br>
                <p>$pro_desc</p>
            </div>
                ";
                    }
                }
            }
            ?>

            
           

        </div>
        <!-- <a href='product_details.php?add_cart=$pro_id && quantity=1' class='btn'>Add to Cart</a> -->
    </div>
    <script>
        function addToCart() {
            var pro_id = document.getElementById("product_id").innerHTML;
            var quantity = document.getElementById("pro_quantity").value;
            var url = "product_details.php?add_cart=" + pro_id + "&&quantity=" + quantity;
            window.location.href = url;
        }
    </script>
    <?php
    if (isset($_GET['add_cart'])) {

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $product_id = $_GET['add_cart'];
            $quantity = $_GET['quantity'];

            $run_check_pro = mysqli_query($con, "select * from cart where product_id='$product_id' and user_id='$user_id'");

            if (mysqli_num_rows($run_check_pro) > 0) {
                echo "";
            } else {

                $fetch_pro = mysqli_query($con, "select * from products where product_id='$product_id'");
                $fetch_pro = mysqli_fetch_array($fetch_pro);
                $pro_title = $fetch_pro['product_title'];

                $ip = get_ip();

                $run_insert_pro = mysqli_query($con, "insert into cart (product_id, user_id, product_title, ip_address, quantity) values('$product_id', '$user_id', '$pro_title', '$ip', '$quantity')");

                if ($run_insert_pro) {
                    header("location:products.php");
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                }
            }
        } else {
            header("location:account.php");
        }
    }
    ?>


    <!-------- titile-------->

    <div class="small-container">
        <div class="row row-2">
            <h2>Related Products</h2>
            <!-- <p>View More</p> -->
            <a href="products.php">View More</a>
        </div>
    </div>


    <!-------- products-------->
    <div class="small-container">


        <div class="fearured-products">

            <?php

            if (isset($_GET['pro_id'])) {
                $product_id = $_GET['pro_id'];


                $get_pro = "SELECT * FROM products ORDER BY product_id DESC";
                $run_pro = mysqli_query($con, $get_pro);

                $count = 0; // Initialize counter variable

                while ($row_pro = mysqli_fetch_array($run_pro)) {
                    $pro_id = $row_pro['product_id'];
                    $pro_cat = $row_pro['product_cat'];
                    $pro_brand = $row_pro['product_brand'];
                    $pro_title = $row_pro['product_title'];
                    $pro_price = $row_pro['product_price'];
                    $pro_desc = $row_pro['product_desc'];
                    $pro_img_01 = $row_pro['product_img_01'];
                    $pro_img_02 = $row_pro['product_img_02'];
                    $pro_img_03 = $row_pro['product_img_03'];
                    $pro_img_04 = $row_pro['product_img_04'];
                    $pro_img_05 = $row_pro['product_img_05'];

                    if ($pro_id !== $product_id) {
                        echo "
                        <div class='col-4 item_holder product_brand_$pro_brand product_category_$pro_cat'>
                        <a href='product_details.php?pro_id=$pro_id'><img src='admin/product_imgs/$pro_img_01'></a>
                        <a href='product_details.php'><h4>$pro_title</h4></a>
                        <div class='rating'>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star-o'></i>
                        </div>
                        <p>Rs.$pro_price.00</p>
                        </div>
                        ";
                    }

                    $count++; // Increment the counter

                    if ($count >= 5) {
                        break; // Exit the loop once 4 items are displayed
                    }
                }
            }
            ?>

        </div>
    </div>

    <!-- ------ footer------ -->

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <!-- <h3>Download Our App</h3>
                    <p>Lorem ipsum dolor sit amet</p> -->
                    <h3>Available Payment Methods</h3>
                    <p>Credit Card/ Debit Card</p>
                    <div class="app-logo">
                        <!-- <img src="images/play-store.png">
                        <img src="images/app-store.png"> -->
                        <img src="images/Payment.png">
                    </div>
                </div>

                <div class="footer-col-2">
                    <img src="images/web-logo-white.png" width="300px">
                    <p>Your journey to musical excellence begins here</p>
                </div>

                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Coupons</li>
                        <li>Products</li>
                        <li>About US</li>
                        <li>Contact</li>
                    </ul>
                </div>

                <div class="footer-col-4">
                    <h3>Follow us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instergram</li>
                        <li>YouTube</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2023 - Tune Mart</p>
        </div>
    </div>

    <!--------js for toggle menu-------->

    <script>
        var menuItems = document.getElementById("menuItems");

        menuItems.style.maxHeight = "0px";

        function menutoggle() {
            if (menuItems.style.maxHeight == "0px") {
                menuItems.style.maxHeight = "200px";
            } else {
                menuItems.style.maxHeight = "0px";
            }
        }
    </script>


    <!-- ------js for product gallery-------->

    <script type="text/JavaScript">
        var productImg = document.getElementById("productImg");
        var smallImg = document.getElementsByClassName("small-img");

        // if (productImg == null) {
        //     console.log('productImg is null');
        // }
        // else{
        //     console.log('productImg is not null');
        // }

        smallImg[0].onclick = function(){
            
            // console.log(productImg);
            productImg.src = smallImg[0].src;
        }

        smallImg[1].onclick = function(){
            productImg.src = smallImg[1].src;
        }

        smallImg[2].onclick = function(){
            productImg.src = smallImg[2].src;
        }

        smallImg[3].onclick = function(){
            productImg.src = smallImg[3].src;
        }
    </script>

</body>

</html>