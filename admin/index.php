<?php
session_start();
include("../config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Store</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>

    <div class="container">
        <div class="navbar">

            <div class="logo">
                <a href=""><img src="../images/web-logo.png" width="125px"></a>
            </div>
            <div class="profile">
                <a href="">Admin Pannel</a>
            </div>

        </div>

        <div class="sub_container">
            <div class="left">
                <a href="view_product.php?action=view_pro"><div class="cell">Genaral</div></a>
                <a href="orders.php">
                    <div class="cell">Orders</div>
                </a>
                <a href="insert_product.php"><div class="cell">Insert Product</div></a>
                <a href="category.php"><div class="cell">Add Category</div></a>
                <a href="brands.php"><div class="cell">Add Brands</div></a>
                <a href="discount.php">
                    <div class="cell">Add Discounts</div>
                </a>
                <a href="feedback.php">
                    <div class="cell">User Feedbacks</div>
                </a>
            </div>
            <div class="right"></div>
        </div>
    </div>






</body>

</html>