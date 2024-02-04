<?php
session_start();
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_title = $_POST['product_title'];
    $product_price = $_POST['product_price'];
    $category_id = $_POST['category'];
    $product_qty = $_POST['product_quantity'];
    $brand_id = $_POST['brand'];
    $product_description =  $_POST['product_description'];

    // Update product details
    $update_query = "UPDATE products SET
                        product_title = '$product_title',
                        product_price = '$product_price',
                        product_qty = '$product_qty',
                        product_cat = '$category_id',
                        product_brand = '$brand_id',
                        product_desc = '$product_description'
                    WHERE product_id = '$product_id'";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        // Handle updating product photos
        for ($i = 1; $i <= 5; $i++) {
            $photo_column = "product_img_0$i";
            $new_photo_key = "new_photo$i";

            if ($_FILES[$new_photo_key]['name'] !== "") {
                // Upload new photo
                $new_photo_name = $product_id . "_photo_$i." . pathinfo($_FILES[$new_photo_key]['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES[$new_photo_key]['tmp_name'], "product_imgs/" . $new_photo_name);

                // Update photo column in the database
                $update_photo_query = "UPDATE products SET $photo_column = '$new_photo_name' WHERE product_id = '$product_id'";
                mysqli_query($con, $update_photo_query);
            }
        }

        echo "<script>alert('Product has been updated successfully!')</script>";
        echo "<script>window.open('view_product.php?action=view_pro','_self')</script>";
    } else {
        echo "Error: " . mysqli_error($con);
        echo "<script>alert('Failed to update product!')</script>";
    }
} else {
    // Handle cases where the form was not submitted properly
    echo "<script>alert('Invalid request!')</script>";
    echo "<script>window.open('view_product.php?action=view_pro','_self')</script>";
}
?>