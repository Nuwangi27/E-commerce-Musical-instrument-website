<?php
session_start();
include("../config.php");


if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve product details
    $result = mysqli_query($con, "SELECT * FROM products WHERE product_id = '$product_id'");
    $row = mysqli_fetch_assoc($result);

    // Display the form for editing
    echo "<form method='post' action='update_product.php' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='product_id' value='" . $row['product_id'] . "'>";

    // Product Title
    echo "<label for='product_title'>Product Title:</label>";
    echo "<input type='text' name='product_title' value='" . $row['product_title'] . "'><br>";

    // Product Price
    echo "<label for='product_price'>Product Price:</label>";
    echo "<input type='text' name='product_price' value='" . $row['product_price'] . "'><br>";

    // Product quantity
    echo "<label for='product_quantity'>Product Quantity:</label>";
    echo "<input min='0' type='number' name='product_quantity' value='" . $row['product_qty'] . "'><br>";

    // Product Description
    echo "<label for='product_description'>Product Description:</label>";
    echo "<textarea name='product_description'>" . $row['product_desc'] . "</textarea><br>";

    // Product Keywords
    echo "<label for='product_keywords'>Product Keywords:</label>";
    echo "<input type='text' name='product_keywords' value='" . $row['product_keywords'] . "'><br>";

    // Product Category (Assuming you have a 'categories' table)
    echo "<label for='category'>Product Category:</label>";
    echo "<select name='category'>";
    $categories = mysqli_query($con, "SELECT * FROM categories");
    while ($category_row = mysqli_fetch_assoc($categories)) {
        $selected = ($category_row['cat_id'] == $row['product_cat']) ? "selected" : "";
        echo "<option value='" . $category_row['cat_id'] . "' $selected>" . $category_row['cat_title'] . "</option>";
    }
    echo "</select><br>";

    // Product Brand (Assuming you have a 'brands' table)
    echo "<label for='brand'>Product Brand:</label>";
    echo "<select name='brand'>";
    $brands = mysqli_query($con, "SELECT * FROM brands");
    while ($brand_row = mysqli_fetch_assoc($brands)) {
        $selected = ($brand_row['brand_id'] == $row['product_brand']) ? "selected" : "";
        echo "<option value='" . $brand_row['brand_id'] . "' $selected>" . $brand_row['brand_name'] . "</option>";
    }
    echo "</select><br>";

    // Product Image
    // Display current product photos
    for ($i = 1; $i <= 5; $i++) {
        $photo_column = "product_img_0$i";
        echo "<label for='photo$i'>Current Photo $i:</label>";
        echo "<img src='product_imgs/" . $row[$photo_column] . "' width='70' height='50'><br>";
    }

    // Allow changing up to 5 product photos
    for ($i = 1; $i <= 5; $i++) {
        echo "<label for='new_photo$i'>New Photo $i:</label>";
        echo "<input type='file' name='new_photo$i'><br>";
    }

    // Add other fields as needed

    echo "<input type='submit' value='Update Product'>";
    echo "</form>";
}
