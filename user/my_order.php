<?php
session_start();
include("../config.php");

if (!isset($_SESSION['email'])) {
    header("location:../account.php");
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the user
$order_query = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result_orders = mysqli_query($con, $order_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="user_profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="../images/web-logo.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="menuItems">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../products.php">Product</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="../contact.php">Conatact</a></li>
                        <li><a href="../account.php">Log In</a></li>
                    </ul>
                </nav>
                <a href="../cart.php"><img src="../images/cart.png" width="30px" height="30px"></a>
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
                    <a href='user_profile.php'><img src='../upload-files/$user_img'></a>   
                    </div>
                        
                    ";
                } else {
                    echo "
                    <div class='profile'>
                    <a href='account.php'><img src='../images/profile-1.png'></a>   
                    </div>   
                    ";
                }

                ?>

                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>

    <div class="user_container">


        <div class="left_container">
            <div class="left">
                <a href="user_profile.php">
                    <div class="cell">Home</div>
                </a>
                <a href="my_order.php">
                    <div class="cell">My Orders</div>
                </a>
                <a href="change_password.php">
                    <div class="cell">Change Password</div>
                </a>
                <a href="../logout.php">
                    <div class="cell">Log Out</div>
                </a>
            </div>
            <div class="right">
                <div class="order_container">
                    <h2 class="topic">My Orders</h2>

                    <?php
                    // Loop through each order
                    while ($row_order = mysqli_fetch_assoc($result_orders)) {
                        $order_id = $row_order['order_id'];
                        $total_amount = $row_order['total_amount'];
                        $order_date = $row_order['order_date'];

                        // Fetch order items for each order
                        $order_items_query = "SELECT order_items.*, products.product_img_01, products.product_price, products.product_title
                                  FROM order_items
                                  INNER JOIN products ON order_items.product_id = products.product_id
                                  WHERE order_items.order_id = '$order_id'";
                        $result_order_items = mysqli_query($con, $order_items_query);

                    ?>
                        <div class="order">
                            <p>Order ID: <?php echo $order_id; ?></p>
                            <p>Total Amount: Rs.<?php echo $total_amount; ?>.00</p>
                            <p>Order Date: <?php echo $order_date; ?></p>

                            <table>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Image</th>
                                    <th>Product Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Product Title</th>
                                    <th>Status</th>
                                </tr>

                                <?php
                                // Loop through each order item
                                while ($row_order_item = mysqli_fetch_assoc($result_order_items)) {
                                    $product_id = $row_order_item['product_id'];
                                    $product_img = $row_order_item['product_img_01'];
                                    $product_price = $row_order_item['product_price'];
                                    $quantity = $row_order_item['quantity'];
                                    $total_price = $product_price * $quantity;
                                    $product_title = $row_order_item['product_title'];
                                    $status = $row_order_item['status'];; // You may get this from your database or set it based on certain conditions

                                ?>
                                    <tr>
                                        <td><?php echo $product_id; ?></td>
                                        <td><img src="../admin/product_imgs/<?php echo $product_img; ?>" alt="Product Image" width="50"></td>
                                        <td>Rs.<?php echo $product_price; ?>.00</td>
                                        <td><?php echo $quantity; ?></td>
                                        <td>Rs.<?php echo $total_price; ?>.00</td>
                                        <td><?php echo $product_title; ?></td>
                                        <td style="color: green;"><?php echo $status; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>

    <!-- Footer content here -->

</body>

</html>