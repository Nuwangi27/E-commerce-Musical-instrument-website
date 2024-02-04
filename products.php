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

    <div class="small-container">

        <div class="row row-2">
            <h2>All Products</h2>
            <div class="search-container">
                <input type="text" id="searchInput" name="user_query" class="search" placeholder="Search">
                <div name="search" class="btn search-btn">Search</div>
                <!-- <input type="submit" name="search" value="search" class="btn search-btn"> -->
            </div>
            <select onchange="sorter()" id="category_selector">
                <option value="0">All Categories</option>

                <?php
                $get_cats = "select * from categories";

                $run_cats =  mysqli_query($con, $get_cats);

                while ($row_cats = mysqli_fetch_array($run_cats)) {
                    $cat_id = $row_cats['cat_id'];

                    $cat_title = $row_cats['cat_title'];

                    echo "<option value='$cat_id'>$cat_title</option>";
                }

                ?>
            </select>

            <?php
            ?>

            <select onchange="sorter()" id="brand_selector">
                <option value="0">All Brands</option>

                <?php
                $get_brands = "select * from brands";

                $run_brands =  mysqli_query($con, $get_brands);

                while ($row_brands = mysqli_fetch_array($run_brands)) {
                    $brand_id = $row_brands['brand_id'];

                    $brand_name = $row_brands['brand_name'];

                    echo "<option value='$brand_id'>$brand_name</option>";
                }
                ?>
            </select>
        </div>

        <div class="row-products">

            <?php
            $get_pro = "SELECT * FROM products ORDER BY product_id DESC";

            $run_pro = mysqli_query($con, $get_pro);

            while ($row_pro = mysqli_fetch_array($run_pro)) {
                $pro_id = $row_pro['product_id'];
                $pro_cat = $row_pro['product_cat'];
                $pro_brand = $row_pro['product_brand'];
                $pro_title = $row_pro['product_title'];
                $pro_price = $row_pro['product_price'];
                $pro_desc = $row_pro['product_desc'];
                $pro_keyword = $row_pro['product_keywords'];
                $pro_img_01 = $row_pro['product_img_01'];
                $pro_img_02 = $row_pro['product_img_02'];
                $pro_img_03 = $row_pro['product_img_03'];
                $pro_img_04 = $row_pro['product_img_04'];
                $pro_img_05 = $row_pro['product_img_05'];


                echo "<div class='col-4 item_holder product_brand_$pro_brand product_category_$pro_cat' data-keyword='$pro_keyword'>
                <a href='product_details.php?pro_id=$pro_id'><img src='admin/product_imgs/$pro_img_01'></a>
                <a href='product_details.php'><h4>$pro_title</h4></a>";

                // Check if the product has ratings
                if (isset($row_pro['product_id'])) {
                    $product_id = $row_pro['product_id'];

                    // Retrieve ratings for the specified product ID
                    $get_ratings_query = "SELECT * FROM ratings WHERE product_id = '$product_id'";
                    $run_ratings_query = mysqli_query($con, $get_ratings_query);

                    // Check if there are ratings for the product
                    if (mysqli_num_rows($run_ratings_query) > 0) {
                        $total_ratings = 0;
                        $total_users = 0;

                        // Loop through the ratings and calculate the total rating and user count
                        while ($row = mysqli_fetch_assoc($run_ratings_query)) {
                            $rating_value = $row['rating_value'];
                            $total_ratings += $rating_value;
                            $total_users++;
                        }

                        // Calculate the average rating
                        $average_rating = $total_ratings / $total_users;

                        // Display the average rating as stars
                        echo "<div class='rating'>";
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $average_rating) {
                                echo "<i class='fa fa-star'></i>"; // Filled star
                            } else {
                                echo "<i class='fa fa-star-o'></i>"; // Empty star
                            }
                        }
                        echo "</div>";

                        // Display the average rating as a decimal number
                        // echo "<p>Average Rating: " . number_format($average_rating, 2) . "</p>";
                    } else {
                        echo "
                        <div class='rating'>
                        <i class='fa fa-star-o'></i>
                        <i class='fa fa-star-o'></i>
                        <i class='fa fa-star-o'></i>
                        <i class='fa fa-star-o'></i>
                        <i class='fa fa-star-o'></i>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>Product ID not provided.</p>";
                }

                echo "<p>Rs.$pro_price.00</p></div>";
            }
            ?>



        </div>

        <div class="page-btn">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>&#8594</span>
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

    <!-- ------js for toggle menu------ -->

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

        function sorter() {
            itemBrandAndCategorySort();
        }

        function itemBrandAndCategorySort() {
            var brandType = document.getElementById("brand_selector").value;
            var categoryType = document.getElementById("category_selector").value;

            itemHider(brandType, categoryType);

            if (brandType != 0) {
                var brandTagName = "product_brand_" + brandType;
                var brandDisplayItems = document.getElementsByClassName(brandTagName);
                var brandItems = Array.from(brandDisplayItems);
                brandItems.forEach(item => {
                    if (window.getComputedStyle(item).getPropertyPriority("display") == "none")
                        item.style.display = "block";
                });
            } else {
                itemHider(brandType, categoryType);
            }

            if (categoryType != 0) {
                var categoryTagName = "product_category_" + categoryType;
                var categoryDisplayItems = document.getElementsByClassName(categoryTagName);
                var categoryItems = Array.from(categoryDisplayItems);
                categoryItems.forEach(item => {
                    if (window.getComputedStyle(item).getPropertyPriority("display") == "none")
                        item.style.display = "block";
                });
            } else {
                itemHider(brandType, categoryType);
            }
        }

        function itemHider(brandType, categoryType) {
            var allItems = document.getElementsByClassName("item_holder");
            var items = Array.from(allItems);

            items.forEach(item => {
                var brandCondition = brandType == 0 || item.classList.contains("product_brand_" + brandType);
                var categoryCondition = categoryType == 0 || item.classList.contains("product_category_" + categoryType);

                if (brandCondition && categoryCondition) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        }


        function searchProducts() {
            var searchKeyword = document.getElementById("searchInput").value.toLowerCase();

            var allItems = document.getElementsByClassName("item_holder");
            var items = Array.from(allItems);

            items.forEach(item => {
                var productTitle = item.querySelector("h4").innerText.toLowerCase();
                var productKeyword = item.dataset.keyword.toLowerCase();

                // Check if the search keyword is present in the title or product_keyword
                if (productTitle.includes(searchKeyword) || productKeyword.includes(searchKeyword)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        }

        document.querySelector(".search-btn").addEventListener("click", searchProducts);
    </script>




</body>

</html>