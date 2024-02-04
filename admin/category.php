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
                <div class="cat">
                    <div class="add_cat">
                        <form action="" method="post" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <th>Insert New Category Here</th>
                                </tr>

                                <tr class="details_tr" style="margin-top: 30px;">
                                    <td>Add New Cateogry:</td>
                                    <td><input type="text" name="product_cat" required></td>
                                </tr>

                                <tr class="details_tr center">
                                    <td><input type="submit" name="insert_cat" value="Add Category" class="btn" /></td>
                                </tr>

                            </table>
                        </form>
                    </div>

                    <?php
                    if (isset($_POST['insert_cat'])) {

                        $product_cat = mysqli_real_escape_string($con, $_POST['product_cat']);

                        $insert_cat = mysqli_query($con, "insert into categories (cat_title) values ('$product_cat') ");

                        if ($insert_cat) {
                            echo "<script>alert('Product category has been inserted successfully!')</script>";

                            echo "<script>window.open(window.location.href,'_self')</script>";
                        }
                    }
                    ?>


                    <div class="view_cat"></div>
                </div>

            </div>
        </div>


    </div>



</body>


</html>