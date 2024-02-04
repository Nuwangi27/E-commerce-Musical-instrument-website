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
                    <form action="insert_product.php" method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <th>Insert New Post Here</th>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Title:</td>
                                <td><input type="text" name="product_title" placeholder="Product Title" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Category:</td>
                                <td>
                                    <select name="product_cat">
                                        <option disabled selected>Select a Category</option>

                                        <?php
                                        $get_cats = "select * from categories";

                                        $run_cats =  mysqli_query($con, $get_cats);

                                        while ($row_cats = mysqli_fetch_array($run_cats)) {
                                            $cat_id = $row_cats['cat_id'];

                                            $cat_title = $row_cats['cat_title'];

                                            echo "<option value='$cat_id'>$cat_title</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Brand:</td>
                                <td>
                                    <select name="product_brand">
                                        <option disabled selected>Select a Brand</option>

                                        <?php
                                        $get_brands = "select * from brands";

                                        $run_brands =  mysqli_query($con, $get_brands);

                                        while ($row_brands = mysqli_fetch_array($run_brands)) {
                                            $brand_id = $row_brands['brand_id'];

                                            $brand_name = $row_brands['brand_name'];

                                            echo "<option value='$brand_id'>$brand_name</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <!-- <tr class="details_tr">
                                <td>Product Color:</td>
                                <td>
                                    <select name="colors[]" id="colorSelect">
                                        <option disabled selected>Select Colors</option>
                                        <option value="red">Red</option>
                                        <option value="blue">Blue</option>
                                        <option value="green">Green</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="details_tr">
                                <td></td>
                                <td>
                                    <button type="button" id="addColor">Add Color</button>
                                </td>
                            </tr> -->

                            <tr class="details_tr">
                                <td>Product Image 01:</td>
                                <td><input type="file" name="product_img_01" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Image 02:</td>
                                <td><input type="file" name="product_img_02" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Image 03:</td>
                                <td><input type="file" name="product_img_03" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Image 04:</td>
                                <td><input type="file" name="product_img_04" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Image 05:</td>
                                <td><input type="file" name="product_img_05" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Price:</td>
                                <td><input type="text" name="product_price" placeholder="Product Price" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Quantity:</td>
                                <td><input type="number" min="1" name="product_quantity" placeholder="Product Quantity" required></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Description:</td>
                                <td><textarea cols="20" rows="10" name="product_desc" required></textarea></td>
                            </tr>

                            <tr class="details_tr">
                                <td>Product Keywords:</td>
                                <td><input type="text" name="product_keywords" placeholder="Product Keywords" required></td>
                            </tr>

                            <tr class="submit_tr">
                                <td><input class="btn" type="submit" name="insert_post" value="Insert Product Now"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <script>
        // JavaScript code for adding more color select fields
        document.getElementById("addColor").addEventListener("click", function() {
            const colorSelect = document.getElementById("colorSelect");
            const newSelect = colorSelect.cloneNode(true);
            colorSelect.parentNode.appendChild(newSelect);
        });
    </script>



</body>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_qty = $_POST['product_quantity'];
    $product_desc = trim(mysqli_real_escape_string($con, $_POST['product_desc']));
    $product_keywords = $_POST['product_keywords'];
    // $colors = $_POST["colors"];

    //getting the image from the field

    $product_img_01 = $_FILES['product_img_01']['name'];
    $product_img_01_tmp = $_FILES['product_img_01']['tmp_name'];

    move_uploaded_file($product_img_01_tmp, "product_imgs/$product_img_01");

    $product_img_02 = $_FILES['product_img_02']['name'];
    $product_img_02_tmp = $_FILES['product_img_02']['tmp_name'];

    move_uploaded_file($product_img_02_tmp, "product_imgs/$product_img_02");

    $product_img_03 = $_FILES['product_img_03']['name'];
    $product_img_03_tmp = $_FILES['product_img_03']['tmp_name'];

    move_uploaded_file($product_img_03_tmp, "product_imgs/$product_img_03");

    $product_img_04 = $_FILES['product_img_04']['name'];
    $product_img_04_tmp = $_FILES['product_img_04']['tmp_name'];

    move_uploaded_file($product_img_04_tmp, "product_imgs/$product_img_04");

    $product_img_05 = $_FILES['product_img_05']['name'];
    $product_img_05_tmp = $_FILES['product_img_05']['tmp_name'];

    move_uploaded_file($product_img_05_tmp, "product_imgs/$product_img_05");

    $insert_product = "insert into products (product_cat,product_brand,product_title,product_price,product_qty,product_desc,product_keywords,product_img_01,product_img_02,product_img_03,product_img_04,product_img_05) values('$product_cat','$product_brand','$product_title','$product_price','$product_qty','$product_desc','$product_keywords','$product_img_01','$product_img_02','$product_img_03','$product_img_04','$product_img_05')";

    $insert_pro = mysqli_query($con, $insert_product);

    if ($con->query($insert_pro) === FALSE) {
        echo "Error: " . $con->error;
    } else {
        $product_id = $con->insert_id;
        
        // foreach ($colors as $color) {
        //     $insert_color_sql = "INSERT INTO product_colors (product_id, color) VALUES ('$product_id', '$color')";
        //     if ($con->query($insert_color_sql) === FALSE) {
        //         echo "Error: " . $con->error;
        //     }
        // }
        echo "<script>alert('Product has been insert successfully')</script>";
    }
}
?>

</html>