<?php
session_start();
include("../config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>

    <div class="order-container">
        <div class="navbar">

            <div class="logo">
                <a href=""><img src="../images/web-logo.png" width="125px"></a>
            </div>
            <div class="profile">
                <a href="admin_dashboard.php">Admin Pannel</a>
            </div>

        </div>
        <div class="sub_container">
            <div class="left">
                <a href="view_product.php?action=view_pro">
                    <div class="cell">Genaral</div>
                </a>
                <a href="orders.php">
                    <div class="cell">Orders</div>
                </a>
                <a href="insert_product.php">
                    <div class="cell">Insert Product</div>
                </a>
                <a href="category.php">
                    <div class="cell">Add Category</div>
                </a>
                <a href="brands.php">
                    <div class="cell">Add Brands</div>
                </a>
                <a href="discount.php">
                    <div class="cell">Add Discounts</div>
                </a>
                <a href="feedback.php">
                    <div class="cell">User Feedbacks</div>
                </a>

            </div>
            <div class="right">

                <div class="header">
                    <h2 style="margin-top: 10px; text-align: center;">Admin - Orders</h2>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr class="tr">
                                <th>Order ID</th>
                                <th>Date and Time</th>
                                <th>User ID</th>
                                <th>Product ID</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Retrieve orders from the database
                            $order_query = "SELECT * FROM orders ORDER BY order_id DESC";
                            $order_result = mysqli_query($con, $order_query);

                            while ($order_row = mysqli_fetch_assoc($order_result)) {
                                $order_id = $order_row['order_id'];
                                $order_date_time = $order_row['order_date'];
                                $user_id = $order_row['user_id'];

                                // Retrieve order items for each order
                                $order_items_query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
                                $order_items_result = mysqli_query($con, $order_items_query);

                                while ($item_row = mysqli_fetch_assoc($order_items_result)) {
                                    $product_id = $item_row['product_id'];
                                    $quantity = $item_row['quantity'];
                                    $status = $item_row['status']; // Fetch the status

                                    // Retrieve product details
                                    $product_query = "SELECT * FROM products WHERE product_id = '$product_id'";
                                    $product_result = mysqli_query($con, $product_query);

                                    while ($product_row = mysqli_fetch_assoc($product_result)) {
                                        $product_image = $product_row['product_img_01'];
                                        $product_price = $product_row['product_price'];
                                        $product_title = $product_row['product_title'];

                                        // Calculate total price for the item
                                        $total_price = $product_price * $quantity;

                                        // Display the order details in the table
                                        echo "<tr>
                                        <td>$order_id</td>
                                        <td>$order_date_time</td>
                                        <td>$user_id</td>
                                        <td>$product_id</td>
                                        <td><img src='product_imgs/$product_image' width='50px' height='50px'></td>
                                        <td>Rs.$product_price.00</td>
                                        <td>$quantity</td>
                                        <td>Rs.$total_price.00</td>
                                        <td>$status</td>
                                        <td><button onclick='acceptOrder($order_id, $product_id)'>Accept</button></td>
                                        </tr>";
                                    }
                                }
                            }
                            ?>

                            <script>
                                function acceptOrder(order_id, product_id) {
                                    // Perform AJAX request to update the order status
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState == 4 && xhr.status == 200) {
                                            // Update the status in the table
                                            var statusCell = document.querySelector("td[data-order='" + order_id + "'][data-product='" + product_id + "']");
                                            statusCell.innerHTML = xhr.responseText;

                                            // Disable the button after clicking
                                            var button = statusCell.nextElementSibling.querySelector("button");
                                            button.disabled = true;

                                            
                                        }
                                    };
                                    xhr.open("GET", "update_order_status.php?order_id=" + order_id + "&product_id=" + product_id, true);
                                    xhr.send();
                                }
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>



</body>


</html>