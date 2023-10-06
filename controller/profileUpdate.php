<?php

include "../database/env.php";
session_start();



$id = $_SESSION['auth']['id'];
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$profileImage = $_FILES['profile_img'];
$errors = [];
$acceptedFiles = ['jpg', 'png', 'svg'];
$extension = pathinfo($profileImage['name'])['extension'];


// VALIDATION
if( $profileImage['size'] == 0 ){
    $errors['Profile_img_error'] = "Image is empty";
}else if(!in_array($extension, $acceptedFiles)){
    $errors['Profile_img_error'] = "Supported Types are jpg, png, svg";
} else if($profileImage['size'] > 65200){
    $errors['Profile_img_error'] = "Total image size is 500kb";
}

// REDIRECT
if(count($errors) > 0){
    // FORWARD
    // MOVE UPLOADED FILE
    $file_name = "user-" . uniqid() . ".$extension";
    move_uploaded_file($profileImage['tmp_name'], "../uploads/$file_name");
    // print_r($file_name);
    if(!is_dir("../uploads/users")){
         mkdir("../uploads/users");
    }
    $uploadedfiles = move_uploaded_file($profileImage['tmp_name'],"../uploads/users/$fileName");

   $query= "UPDATE users SET fname='$fname',lname='$lname',email='$email', profile_img= '$file_name' WHERE id=" . '$_SESSION["auth"]["id"]';

   $res = mysqli_query($conn, $query);
   
//    $result = mysqli_fetch_all($res);

    // UPDATE
    $_SESSION['auth']['fname']= $fname;
    $_SESSION['auth']['lname']= $lname;
    $_SESSION['auth']['email']= $email;
    $_SESSION['auth']['profile']= $file_name;

    header("location : ../backend/profile.php");
}else{
    header("location: ../backend/profile.php");
}
