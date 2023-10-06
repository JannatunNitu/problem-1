<?php
session_start();
include "../database/env.php";


$id = $_SESSION['auth']['id'];
$old_password = $_REQUEST['old_password'];
$password = $_REQUEST['password'];
$confirm_password = $_REQUEST['confirm_password'];
$encpassword = password_hash($password, PASSWORD_BCRYPT);
$errors = [];

$query = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$is_varified = password_verify($old_password, $user['password']);
// print_r($is_varified);
// exit();

// VARIFIED
if($is_varified){
    // Moving Forward

    if($password == $confirm_password){
    // Password UPDATE
    $query = "UPDATE users SET password='$encpassword' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    var_dump($result);


    }


}else{
    // Backward
    $errors['old_errors'] = "Password is incorrect";
    $_SESSION['form_errors'] = $errors;
    // REDIRECT
    header("location: ../backend/profile.php");
}