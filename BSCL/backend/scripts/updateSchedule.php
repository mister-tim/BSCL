<?php
session_start();
include_once "./dbcon.php";

$update = $_POST["update"];
$query = "UPDATE otherInfo.data SET textblock='".$update."' WHERE title='Schedule';";
$launch = mysqli_query($conn, $query);
echo "<script> localStorage.clear(); console.log('oof'); </script>";
echo "<h1>Update Complete!<h1>";
echo "<a href='../home.php'>Home</a>";