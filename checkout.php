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
                        <li><a href="account.php">Account</a></li>
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
                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>


    <div class="small-container cart-page">

        <h2 class="checkout-topic">Check Out</h2>

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
                header("location:cart.php");
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
                    <form id="pay" method="post">
                        <td><a href="index.php" class="checkout_btn">Pay</a></td>
                    </form>
                </tr>
            </table>
        </div>


    </div>

    <?php
    $user_id = $_SESSION['user_id'];
    $ip = get_ip();
    $run_cart = mysqli_query($con, "select * from cart where ip_address='$ip' and user_id='$user_id'");
    
    // Initialize an empty array to store order_items
    $order_items = array();
    
    while ($fetch_cart = mysqli_fetch_array($run_cart)) {
        $product_id = $fetch_cart['product_id'];
        $quantity = $fetch_cart['quantity'];
    
        // Add order item details to the array
        $order_items[] = array(
            'product_id' => $product_id,
            'quantity' => $quantity
        );
    }
    
    // Calculate the total amount
    $total = 0;
    
    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
    
        $result_product = mysqli_query($con, "select * from products where product_id = $product_id");
        while ($fetch_product = mysqli_fetch_array($result_product)) {
            $product_price = $fetch_product['product_price'];
            $values_qty = $product_price * $quantity;
            $total += $values_qty;

            // Update product quantity in the database
            $new_quantity = $fetch_product['product_qty'] - $quantity;
            mysqli_query($con, "UPDATE products SET product_qty = $new_quantity WHERE product_id = $product_id");
        }
    }
    
    // Insert into orders table
    $insert_order_query = "INSERT INTO orders (user_id, total_amount) VALUES ('$user_id', '$total')";
    mysqli_query($con, $insert_order_query);
    
    // Retrieve the order ID of the newly inserted order
    $order_id = mysqli_insert_id($con);
    
    // Insert into order_items table
    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $insert_order_item_query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
        mysqli_query($con, $insert_order_item_query);
    }
    
    // Clear the cart for the user
    mysqli_query($con, "DELETE FROM cart WHERE user_id='$user_id'");
    ?>




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