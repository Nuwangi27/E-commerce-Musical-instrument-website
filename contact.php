<?php
session_start();
include("config.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="header">
        <div class="contact-container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="images/web-logo.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="menuItems">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Product</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Conatact</a></li>
                        <li><a href="account.php">Log In</a></li>
                    </ul>
                </nav>
                <a href="cart.php"><img src="images/cart.png" width="30px" height="30px"></a>
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
                    <a href='user/user_profile.php'><img src='upload-files/$user_img'></a>   
                    </div>
                        
                    ";
                } else {
                    echo "
                    <div class='profile'>
                    <a href='account.php'><img src='images/profile-1.png'></a>   
                    </div>   
                    ";
                }

                ?>
                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>

            <div class="row">
                <div class="col-2">
                    <h1>Contact Us</h1>
                </div>
                <div class="col-2">
                    <img src="images/cover.png" class="contact-img">
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------featured categories----------------- -->
    <section class="location">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.2601978258454!2d79.8941683140948!3d6.738080222502556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2453836c75e31%3A0xabc8eab54326f914!2sOrion%20Technology%20Rebuilders!5e0!3m2!1sen!2slk!4v1661784464676!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <section class="contact-us">
        <div class="row">
            <div class="contact-col">
                <div>
                    <i class="fa fa-home"></i>
                    <span>
                        <h5>Tune Mart</h5>
                        <p>14 Ariyadasa Dharmabandu Mawatha, Moratuwa</p>
                    </span>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                    <span>
                        <h5>+94 01 033 3638</h5>
                        <p>24 Hour Service</p>
                    </span>
                </div>
                <div>
                    <i class="fa fa-envelope-o"></i>
                    <span>
                        <h5>tunemart@gmail.com</h5>
                        <p>Email us your query</p>
                    </span>
                </div>
            </div>
            <div class="contact-col">
                <form action="contact.php" method="post">
                    <p>You need to login first!</p>
                    <input type="text" name="name" placeholder="Enter Your Name" required>
                    <input type="email" name="email" placeholder="Enter Email Address">
                    <textarea rows="8" name="message" placeholder="Message"></textarea>
                    <div class='rating'>
                        <input type="hidden" name="rating" id="rating" value="0">
                        <i class='fa fa-star-o' data-index="1"></i>
                        <i class='fa fa-star-o' data-index="2"></i>
                        <i class='fa fa-star-o' data-index="3"></i>
                        <i class='fa fa-star-o' data-index="4"></i>
                        <i class='fa fa-star-o' data-index="5"></i>
                    </div>
                    <button type="submit" class="visit-btn clr-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            if (isset($_SESSION['user_id'])) {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $message = mysqli_real_escape_string($con, $_POST['message']);
            $rating = mysqli_real_escape_string($con, $_POST['rating']);
    
            // Insert data into the feedback table
            $insert_query = "INSERT INTO feedback (user_id, name, email, message, rating) VALUES ('$user_id', '$name', '$email', '$message', '$rating')";
            mysqli_query($con, $insert_query);
    
            // You can add a success message or redirect the user to a thank-you page
            // echo "<script>alert('Feedback submitted successfully!')</script>";
        } else {
            // User is not logged in, redirect to account.php
            echo "<script>alert('You need to login first!')</script>";
        }
    }
    
    ?>
    <script>
        const stars = document.querySelectorAll('.rating i');
        const ratingInput = document.getElementById('rating');
        const form = document.querySelector('form');

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                highlightStars(index);
            });

            star.addEventListener('mouseout', () => {
                resetStars();
                highlightStars(ratingInput.value - 1); // Highlight stars up to the selected value
            });

            star.addEventListener('click', (event) => {
                // Prevent the default form submission
                event.preventDefault();

                // Set the value of the hidden input
                ratingInput.value = index + 1;

                // Highlight stars up to the clicked star
                highlightStars(index);
            });
        });

        function highlightStars(index) {
            stars.forEach((star, i) => {
                if (i <= index) {
                    star.classList.remove('fa-star-o');
                    star.classList.add('fa-star');
                } else {
                    star.classList.remove('fa-star');
                    star.classList.add('fa-star-o');
                }
            });
        }

        function resetStars() {
            stars.forEach(star => {
                star.classList.remove('fa-star');
                star.classList.add('fa-star-o');
            });
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


</body>

</html>