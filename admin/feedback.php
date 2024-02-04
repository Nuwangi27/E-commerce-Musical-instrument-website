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
                                <table>
                                    <thead>
                                        <tr class="tr">
                                            <th>Feedback ID</th>
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Rating</th>
                                            <th>Message</th>
                                            <th>Date and Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Retrieve feedback from the database
                                        $feedback_query = "SELECT * FROM feedback";
                                        $feedback_result = mysqli_query($con, $feedback_query);

                                        while ($feedback_row = mysqli_fetch_assoc($feedback_result)) {
                                            $feedback_id = $feedback_row['id'];
                                            $user_id = $feedback_row['user_id'];
                                            $feedback_name = $feedback_row['name'];
                                            $feedback_email = $feedback_row['email'];
                                            $feedback_rating = $feedback_row['rating'];
                                            $feedback_text = $feedback_row['message'];
                                            $feedback_date_time = $feedback_row['created_at'];

                                            echo "<tr>
                                            <td>$feedback_id</td>
                                            <td>$user_id</td>
                                            <td>$feedback_name</td>
                                            <td>$feedback_email</td>
                                            <td>$feedback_rating</td>
                                            <td>$feedback_text</td>
                                            <td>$feedback_date_time</td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </table>
                        </form>
                    </div>

                    <div class="view_cat"></div>
                </div>

            </div>
        </div>


    </div>

</body>


</html>