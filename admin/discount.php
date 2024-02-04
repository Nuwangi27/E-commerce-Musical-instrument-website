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

    <div class="container">
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
                <div class="insert_container">
                    <form action="discount.php" method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <th>Insert Item to Discount Area</th>
                            </tr>
                            <form method="post" enctype="multipart/form-data">
                                <table>

                                    <tr>
                                        <td>Product ID:</td>
                                        <td><input type="text" name="product_id" required></td>
                                    </tr>
                                    <tr>
                                        <td>Discount Description:</td>
                                        <td><textarea name="discount_desc" rows="4" cols="50" required></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Discount Image:</td>
                                        <td><input type="file" name="discount_img"></td>
                                    </tr>
                                    <tr>
                                        <td>Discount Amount (%):</td>
                                        <td><input type="number" name="discount_amount" min="1" max="100" required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><input type="submit" name="submit_discount" value="Add Discount"></td>
                                    </tr>
                                </table>
                            </form>
                        </table>
                    </form>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $product_id = $_POST['product_id'];
                        $discount_desc = trim(mysqli_real_escape_string($con, $_POST['discount_desc']));
                        $discount_amount = $_POST['discount_amount'];
                    
                        // Getting the image from the field
                        $discount_img = $_FILES['discount_img']['name'];
                        $discount_img_tmp = $_FILES['discount_img']['tmp_name'];
                    
                        move_uploaded_file($discount_img_tmp, "images/discount/$discount_img");
                    
                        $insert_discount = "INSERT INTO discounts (product_id, discount_desc, discount_amount, discount_img) VALUES ('$product_id', '$discount_desc', '$discount_amount', '$discount_img')";
                    
                        $insert_discount_query = mysqli_query($con, $insert_discount);
                    
                        if ($insert_discount_query) {
                            echo "<script>alert('Discount has been added successfully')</script>";
                        } else {
                            echo "Error: " . mysqli_error($con);
                        }
                    }
                    ?>

                </div>
            </div>
        </div>


    </div>



</body>

</html>