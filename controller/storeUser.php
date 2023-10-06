<?php

session_start();
include "../database/env.php";

$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$email= $_REQUEST['email'];
$password = $_REQUEST['password'];
$encpassword = password_hash($password, PASSWORD_BCRYPT);
$comfirmpassword = $_REQUEST['comfirmpassword'];
$errors = [];


// VALIDATION

if(empty($fname)){
   $errors['fname_error'] = "Please Enter your First Name";
}
if(empty($lname)){
    $errors['lname_error'] = "Please Enter your Last Name";
 }
 if(empty($email)){
    $errors['email_error'] = "Please Enter your email address";
 }
 else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email_error'] = "Please Enter a valid email address";
 }

 if(empty($password)){
    $errors['password_error'] = "Please Enter password";
 } else if(strlen($password) < 8){
    $errors['password_error'] = "Your password is short";
 } else if($password != $comfirmpassword){
    $errors['password_error'] = "Your password didn't match";
 }



//  ERROR REDIRECT

if(count($errors) > 0 ){
    $_SESSION['register_error'] = $errors;
    header ("Location: ../backend/register.php");
} else{
    $query = "INSERT INTO users(fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$encpassword')";
     $result = mysqli_query($conn, $query);
     if($result){
        header("location: ../backend/login.php");
     }
}