<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['order_id']) && isset($_GET['product_id'])) {
    $order_id = $_GET['order_id'];
    $product_id = $_GET['product_id'];

    // Update the status in the order_items table
    $update_status_query = "UPDATE order_items SET status = 'Accepted' WHERE order_id = '$order_id' AND product_id = '$product_id'";
    mysqli_query($con, $update_status_query);

    // Return the updated status
    echo "Accepted";
    echo "<script>alert('Product has been insert successfully')</script>";
} else {
    echo "Invalid request!";
}
?>