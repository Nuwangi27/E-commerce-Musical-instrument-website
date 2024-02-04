<?php

require "config.php";

if(isset($_POST['email']) && isset($_POST['password'])){

    // For Security reasons
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if(empty($email) || empty($password)){
        header("Location:account.php?result=Invalid username or password.");
    }
    else {
        $login_query = "SELECT id, user_password email FROM users WHERE email = '$email'";

        if($q_return = mysqli_query($conn, $login_query)){
            $login_result = mysqli_fetch_assoc($q_return);
            echo $login_result['user_password'];
            if($login_result['user_password'] == $password){
                // Login Successful
                // Initializing Session Variables
                $_SESSION["current_user_id"] = $login_result['id'];
                $_SESSION["current_user_email"] = $login_result['email'];

            }
            else{
                echo "<script>alert('Password or email is incorrect, Please try again!')</script>";
                exit();
            }
        }
        else{
            echo "<script>alert('Password or email is incorrect, Please try again!')</script>";
            exit();
        }
    }

}
else{
    header("Location:account.php");
}

?>