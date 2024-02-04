<?php
session_start();
include("../config.php");

if (!isset($_SESSION['email'])) {
    header("location:../account.php");
}
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
                        <li><a href="../contact.php">Conatact</a></li>
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

    <?php
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $run_query_by_id = mysqli_query($con, "select * from users where id = '$user_id'");
        while ($row_user = mysqli_fetch_array($run_query_by_id)) {
            $user_img = $row_user['image'];
            $user_name = $row_user['name'];
            $user_email = $row_user['email'];
            $address = $row_user['address'];
        }
    }
    ?>

    <div class="sub_container">
        <div class="container light-style flex-grow-1 container-p-y">
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" href="my_order.php">My Orders</a>
                            <a class="list-group-item list-group-item-action" href="change_password.php">Change password</a>
                            
                            <a class="list-group-item list-group-item-action" href="../logout.php">Log Out</a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <?php
                                    echo "
                                    <img src='../upload-files/$user_img' alt class='d-block ui-w-80'>
                                    ";

                                    ?>
                                    <div class="media-body ml-4">
                                        <label class="checkout_btn">
                                            Upload new photo
                                            <input type="file" class="account-settings-fileinput">
                                        </label> &nbsp;
                                        <div class="text-light-new small mt-1 cl-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <?php
                                        echo "
                                        <input type='text' class='form-control mb-1' value='$user_name' id='username' onchange='enableSaveButton()'>
                                        ";
                                        ?>

                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <?php
                                        echo "
                                        <input type='text' class='form-control mb-1' value='$user_email' id='email' onchange='enableSaveButton()'>
                                        ";
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <?php
                                        echo "
                                        <input type='text' class='form-control mb-1' value='$address' id='address' onchange='enableSaveButton()'>
                                        ";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                            </div>





                            <div class="tab-pane fade" id="account-info">
             
                            </div>
                            <div class="tab-pane fade" id="account-social-links">

                            </div>
                            <div class="tab-pane fade" id="account-connections">

                            </div>
                            <div class="tab-pane fade" id="account-notifications">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mt-3">
                <button type="button" class="checkout_btn" id="saveChangesBtn" onclick="saveChanges()">Save changes</button>&nbsp;
                <button type="button" class="btn btn-default">Cancel</button>
            </div>
        </div>



    </div>
    <script>
    function enableSaveButton() {
        // Enable the "Save changes" button
        document.getElementById('saveChangesBtn').disabled = false;
    }

    function saveChanges() {
        // Get updated values from input fields
        var updatedUsername = document.getElementById('username').value;
        var updatedEmail = document.getElementById('email').value;
        var updatedAddress = document.getElementById('address').value;

        // Send the updated values to the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_profile.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response from the server
                if (xhr.responseText.trim() === 'success') {
                    alert('Profile updated successfully');
                    // Disable the "Save changes" button after saving
                    document.getElementById('saveChangesBtn').disabled = true;
                } else {
                    alert('Failed to update profile. Please try again.');
                }
            }
        };

        // Send data to the server
        xhr.send('username=' + encodeURIComponent(updatedUsername) + '&email=' + encodeURIComponent(updatedEmail) + '&address=' + encodeURIComponent(updatedAddress));
    }
</script>





    <!-- ------ footer------ -->

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <!-- <h3>Download Our App</h3>
                    <p>Lorem ipsum dolor sit amet</p> -->
                    <h3>Available Payment Methods</h3>
                    <p>Credit Card/ Debit Card</p>
                    <div class="app-logo">
                        <!-- <img src="images/play-store.png">
                        <img src="images/app-store.png"> -->
                        <img src="images/Payment.png">
                    </div>
                </div>

                <div class="footer-col-2">
                    <img src="images/web-logo-white.png" width="300px">
                    <p>Your journey to musical excellence begins here</p>
                </div>

                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Coupons</li>
                        <li>Products</li>
                        <li>About US</li>
                        <li>Contact</li>
                    </ul>
                </div>

                <div class="footer-col-4">
                    <h3>Follow us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instergram</li>
                        <li>YouTube</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2023 - Tune Mart</p>
        </div>
    </div>

    <!-- ------js for toggle menu------ -->

    <script>
        var menuItems = document.getElementById("menuItems");

        menuItems.style.maxHeight = "0px";

        function menutoggle() {
            if (menuItems.style.maxHeight == "0px") {
                menuItems.style.maxHeight = "200px";
            } else {
                menuItems.style.maxHeight = "0px";
            }
        }
    </script>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>


</body>

</html>