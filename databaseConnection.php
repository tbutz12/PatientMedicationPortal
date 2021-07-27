<?php
function connectDB(){
$host = "localhost";
$DBuser = "tmb132";
$DBpassword = "Student_4328325";
$dbname = "tmb132";

// Create connection
$connect = mysqli_connect($host, $DBuser, $DBpassword, $dbname);
// Check connection
if(mysqli_connect_errno()){
    die("Database connection failed:". mysqli_connect_error() . "(" . mysqli_connect_errno(). ")");
}
return $connect;
}
?>