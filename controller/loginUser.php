
<?php
session_start();
include "../database/env.php";

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$errors =[];

if(empty($email)){
    $errors['email_error'] = "Email is required";
}
if(empty($password)){
    $errors['password_error'] = "Password is required";
}

// REDIRECT
if(count($errors) > 0){
    $_SESSION['login_error'] = $errors;
    header("location: ../backend/login.php");
} else{


    // email exit
    $query = "SELECT * FROM users WHERE email= '$email'";
    $res = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($res);
   

    if(mysqli_num_rows($res) > 0){
    //   password check
    $ispasswordCorrect =password_verify($password, $user['password']);
    if($ispasswordCorrect){
        // LOGIN
        $_SESSION['auth'] = $user;
        header("location: ../backend/index.php");
    }else{
        $errors['password_error'] = "Incorrect password";
        $_SESSION['login_error'] = $errors;
        header("location: ../backend/login.php");
    }

    } else{
        $errors['email_error'] = "Incorrect Email Address";
        $_SESSION['login_error'] = $errors;
        header("location: ../backend/login.php");
    }
}