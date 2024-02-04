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
                        <form action="" method="get" enctype="multipart/form-data">
                            <div class="head">
                                Insert New Category Here
                            </div>
                            <table>
                                <!-- <thead style="width: 100%;">
                                <tr>
                                    <th>Insert New Category Here</th>
                                </tr>
                                </thead> -->
                                <thead style="width: 100%;">
                                    <tr style="margin-top: 30px;">
                                        <th class="col_name">ID</th>
                                        <th class="col_name">Title</th>
                                        <th class="col_name">Quantity</th>
                                        <th class="col_name">Price</th>
                                        <th class="col_name">Image</th>
                                        <!-- <th class="col_name">Delete</th> -->
                                        <th class="col_name">Edit</th>
                                    </tr>
                                </thead>

                                <?php
                                $all_products = mysqli_query($con, "select * from products order by product_id DESC ");

                                $i = 1;

                                while ($row = mysqli_fetch_array($all_products)) {
                                ?>
                                    <tbody>
                                        <tr>
                                            <td class="cell_details"><?php echo $row['product_id']; ?></td>
                                            <td class="cell_details"><?php echo $row['product_title']; ?></td>
                                            <td class="cell_details"><?php echo $row['product_qty']; ?></td>
                                            <td class="cell_details"><?php echo "Rs. ";
                                                                        echo $row['product_price'];
                                                                        echo ".00" ?></td>
                                            <td class="cell_details"><img src="product_imgs/<?php echo $row['product_img_01']; ?>" width="70" height="50" /></td>
                                            
                                            <td class="cell_details"><a href="edit_product.php?product_id=<?php echo $row['product_id']; ?>">Edit</a></td>
                                        </tr>
                                    </tbody>
                                <?php $i++;
                                }
                                ?>

                            </table>
                        </form>
                    </div>

                    <?php
                    // Delete Product

                    if (isset($_GET['delete_product'])) {
                        $delete_product = mysqli_query($con, "delete from products where product_id='$_GET[delete_product]'");

                        if ($delete_product) {
                            echo "<script>alert('Product has been deleted successfully!')</script>";

                            echo "<script>window.open('view_product.php?action=view_pro','_self')</script>";
                        }
                    }
                    ?>
                </div>

            </div>
        </div>


    </div>



</body>


</html>