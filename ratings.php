<?php
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>

</body>

</html>

<div class="rating-container">
<?php
if (isset($_GET['pro_id'])) {
    $product_id = $_GET['pro_id'];
}


echo "
            <h1>Rate Product</h1>
            <form method='post'>
            <div class='rating'>
                <input type='hidden' name='rating' id='rating' value='0'>
                <i class='fa fa-star-o' data-index='1'></i>
                <i class='fa fa-star-o' data-index='2'></i>
                <i class='fa fa-star-o' data-index='3'></i>
                <i class='fa fa-star-o' data-index='4'></i>
                <i class='fa fa-star-o' data-index='5'></i>
            </div>
            <button type='submit' class='visit-btn clr-btn'>Send Message</button>
            </form>
            ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $rating = mysqli_real_escape_string($con, $_POST['rating']);

        // Insert data into the ratings table
        $insert_query = "INSERT INTO ratings (product_id, user_id, rating_value) VALUES ('$product_id', '$user_id', '$rating')";

        if (mysqli_query($con, $insert_query)) {
            // You can add a success message or redirect the user to a thank-you page
            // echo "<script>alert('Rating submitted successfully!')</script>";
            header("location: product_details.php?pro_id=$product_id");
        } else {
            // Handle the error
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // User is not logged in, redirect to account.php
        echo "<script>alert('You need to login first!')</script>";
    }
}


?>
</div>


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