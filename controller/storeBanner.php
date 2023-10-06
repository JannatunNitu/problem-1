<?php
// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
include "../database/env.php";

$title =$_REQUEST['title'];
$detail =$_REQUEST['detail'];
$cta_title =$_REQUEST['cta-title'];
$cta_link =$_REQUEST['cta-link'];
$video_link =$_REQUEST['video-link'];
$bannerImg =$_FILES['banner-img'];

// *unique name
$ext = pathinfo($bannerImg['name'])['extension'];
$file_name = "Banner-" . uniqid() .  ".$ext";
$path = "../uploads/banners";

if(!is_dir($path)){
   mkdir($path);
}

$uploaded_file = move_uploaded_file($bannerImg ['tmp_name'],"../uploads/banners/.$file_name");

if($uploaded_file){
    $query = "INSERT INTO addbanners(title, detail, cta-title, cta-link, video-link, banner-img) VALUES ('$title', '$detail', '$cta_title', '$cta_link', '$video_link', '$file_name')";
    $res = mysqli_query($conn,$query);
    var_dump($res);
}
else{
}