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
    <link rel="stylesheet" href="about.css">
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
                        <li><a href="">About</a></li>
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
                    <h1>About Us</h1>
                </div>
                <div class="col-2">
                    <img src="images/cover.png" class="contact-img">
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------featured categories----------------- -->
    <main class="about-us">

        <div class="middle-section">
            <div class="left">
                <p>
                    Welcome to Tune Mart, where the art of music finds its perfect home. At Tune Mart, we orchestrate more than just
                    a store; we compose an immersive experience for music aficionados and budding musicians alike. Our journey began
                    with a passion for melodies, a dedication to quality, and a vision to create a haven where every note resonates
                    with excellence.<br><br><br>

                    Step into Tune Mart and explore a harmonious convergence of tradition and innovation. Our extensive collection
                    spans the spectrum of musical instruments – from the rich timbre of classic guitars to the nuanced keystrokes of
                    pianos, and the electronic symphony of cutting-edge synthesizers. Whether you're a seasoned maestro or a novice
                    composer, Tune Mart invites you to discover instruments that inspire and elevate your musical odyssey.

                    Beyond the instruments themselves, Tune Mart is a celebration of craftsmanship. Each instrument is a
                    masterpiece, meticulously crafted to deliver not just sound but an unforgettable experience. We curate our
                    selection with an unwavering commitment to quality, ensuring that every product that bears the Tune Mart name
                    meets the highest standards of performance and durability.<br><br><br>

                    But Tune Mart is more than a store; it's a community of music enthusiasts connected by a shared love for the
                    art. We believe that music has the power to unite, inspire, and transform lives. That's why Tune Mart goes
                    beyond transactions – we foster a space where musicians connect, learn, and grow. Our commitment extends beyond
                    the sale, with expert advice, tutorials, and resources to nurture your musical journey.

                    Tune Mart is not just a destination; it's a destination for dreams set to music. We invite you to explore,
                    create, and harmonize with the melodies that define your story. Join us at Tune Mart, where every instrument
                    carries a tune, and every tune tells a story.
                </p>
                <br>
                <div class="card-container">
                    <div class="card">
                        <div class="state">Founder of Tune Mart </div>
                        <div class="owner-name">Mr. Sahan Dilhara
                        </div>
                        <div class="des">
                            <p>
                            I am a mature, positive and hardworking individual, who always strives to achieve the
                            highest standard possible, at any given task. I was promoted twice for exceeding my sales targets.
                            </p>
                        </div>

                    </div>

                    <div class="card-image-container">
                        <div class="card-image">
                            <img src="images/boy1.jpeg" alt="">
                        </div>

                    </div>
                </div>
            </div>

            <div class="right">
                <div class="down"></div>
                <div class="up">
                    <div class="right-img">
                        <img src="images/img1.jpg" alt="">
                    </div>
                    <div class="right-img">
                        <img src="images/img1.jpeg" alt="">
                    </div>
                    <div class="right-img">
                        <img src="images/img4.jpeg" alt="">
                    </div>
                </div>
            </div>
        </div>


    </main>
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