<?php
$con = mysqli_connect("localhost", "root", "", "web_project");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// get ip address
function get_ip()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address  
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//total price
function total_price()
{
    global $con;
    $total = 0;
    $ip = get_ip();

    $run_cart = mysqli_query($con, "select * from cart where ip_address='$ip'");

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
        }
    }

    echo $total;
}
?>