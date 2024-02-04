<?php
session_start();
include("../config.php");

if (!isset($_SESSION['email'])) {
    header("location:../account.php");
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the user
$order_query = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result_orders = mysqli_query($con, $order_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="user_profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="../images/web-logo.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="menuItems">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../products.php">Product</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="..//contact.php">Conatact</a></li>
                        <li><a href="../account.php">Log In</a></li>
                    </ul>
                </nav>
                <a href="../cart.php"><img src="../images/cart.png" width="30px" height="30px"></a>
                <div class="noti_cart_number">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];

                        $ip = get_ip();

                        $run_items = mysqli_query($con, "select * from cart where ip_address='$ip' and user_id='$user_id'");

                        echo $count_items = mysqli_num_rows($run_items);
                    }
                    ?>
                </div>

                <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    $run_query_by_id = mysqli_query($con, "select * from users where id = '$user_id'");
                    while ($row_user = mysqli_fetch_array($run_query_by_id)) {
                        $user_img = $row_user['image'];
                    }
                    echo "
                    <div class='profile'>
                    <a href='user_profile.php'><img src='../upload-files/$user_img'></a>   
                    </div>
                        
                    ";
                } else {
                    echo "
                    <div class='profile'>
                    <a href='account.php'><img src='../images/profile-1.png'></a>   
                    </div>   
                    ";
                }

                ?>

                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>

    <div class="user_container">


        <div class="left_container">
            <div class="left">
                <a href="user_profile.php">
                    <div class="cell">Home</div>
                </a>
                <a href="my_order.php">
                    <div class="cell">My Orders</div>
                </a>
                <a href="change_password.php">
                    <div class="cell">Change Password</div>
                </a>
                <a href="../logout.php">
                    <div class="cell">Log Out</div>
                </a>
            </div>
            <div class="right">
                <div class="order_container">
                    <h2 class="topic">Change Password</h2>
                    <form method="post" action="change_password.php">
                        <div class="form-group">
                            <label class="form-label">Current password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">New password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Repeat new password</label>
                            <input type="password" name="repeat_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn">Change Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <?php
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $current_password = mysqli_real_escape_string($con, $_POST['current_password']);
        $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
        $repeat_password = mysqli_real_escape_string($con, $_POST['repeat_password']);

        // Fetch the current password from the database
        $fetch_password_query = "SELECT password FROM users WHERE id = '$user_id'";
        $result = mysqli_query($con, $fetch_password_query);
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        // Verify the current password
        if ($current_password == $stored_password) {
            // Check if the new password and repeat password match
            if ($new_password == $repeat_password) {
                // Hash the new password before storing it in the database
                // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $update_password_query = "UPDATE users SET password = '$new_password' WHERE id = '$user_id'";
                mysqli_query($con, $update_password_query);
                echo "<script>alert('Password changed successfully!')</script>";
            } else {
                echo "<script>alert('New password and repeat password do not match!')</script>";
            }
        } else {
            echo "<script>alert('Incorrect current password!')</script>";
        }
    }
    ?>

    <!-- Footer content here -->

</body>

</html>