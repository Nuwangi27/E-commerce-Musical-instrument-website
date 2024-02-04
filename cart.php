<?php
session_start();
include("config.php");

if (!isset($_SESSION['email'])) {
    header("location:account.php");
}
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

    <!-------- cart item details-------->

    <div class="small-container cart-page">

        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $total = 0;
            $ip = get_ip();

            $run_cart = mysqli_query($con, "select * from cart where ip_address='$ip' and user_id='$user_id'");
            $count_items = mysqli_num_rows($run_cart);

            if ($count_items == 0) {
                echo "
                <tr>
                        <td>
                            <div class='cart-info'>
                                Cart is empty
                                <div>
                                    <p><?php echo ; ?></p>
                                    
                                    <br>
                                    
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                            <?php echo; ?>
                            </div>
                            <!-- <input type='number' name='qty' value=''> -->
                        </td>
                        <td>Rs.<?php echo; ?>.00</td>
                    </tr>
                    
                ";
            }

            while ($fetch_cart = mysqli_fetch_array($run_cart)) {
                $product_id = $fetch_cart['product_id'];

                $result_product = mysqli_query($con, "select * from products where product_id = $product_id");

                while ($fetch_product = mysqli_fetch_array($result_product)) {
                    $product_price = array($fetch_product['product_price']);

                    $product_title = $fetch_product['product_title'];

                    $product_image = $fetch_product['product_img_01'];

                    $sing_price = $fetch_product['product_price'];

                    $values = array_sum($product_price);

                    //getting quantity of the product

                    $run_qty = mysqli_query($con, "select * from cart where product_id = '$product_id'");

                    $row_qty = mysqli_fetch_array($run_qty);

                    $qty = $row_qty['quantity'];

                    $values_qty = $values * $qty;

                    $total += $values_qty;

            ?>

                    <tr>
                        <td>
                            <div class="cart-info">
                                <img src="admin/product_imgs/<?php echo $product_image; ?>">
                                <div>
                                    <p><?php echo $product_title; ?></p>
                                    <small>price: Rs.<?php echo $sing_price; ?>.00</small>
                                    <br>
                                    <a href="cart.php?remove=<?php echo $product_id; ?>" name="remove">Remove</a>
                                </div>

                                <?php
                                // Check if the 'remove' parameter is set in the URL
                                if (isset($_GET['remove'])) {
                                    $remove_id = $_GET['remove'];

                                    // Remove the item from the cart based on the product_id
                                    mysqli_query($con, "DELETE FROM cart WHERE product_id = '$remove_id' AND user_id='$user_id'");

                                    // Redirect to the cart page to refresh the cart display
                                    header("Location: cart.php");
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <?php echo $qty; ?>
                            </div>
                            <!-- <input type="number" name="qty" value=""> -->
                        </td>
                        <td>Rs.<?php echo $values_qty; ?>.00</td>
                    </tr>

            <?php }
            } ?>

        </table>

        <div class="total-prise">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>Rs.<?php echo $total; ?>.00</td>
                </tr>
                <!-- <tr>
                    <td>Discounts</td>
                    <td>Rs.0.00</td>
                </tr> -->
                <tr>
                    <td>Total</td>
                    <td>Rs.<?php echo $total; ?>.00</td>
                </tr>

                <tr>
                    <td></td>
                    <form id="checkout" method="post">
                        <td><a href="checkout.php" class="checkout_btn">CheckOut</a></td>
                    </form>
                </tr>
            </table>
        </div>


    </div>

    <!-------- footer-------->

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


</body>

</html>