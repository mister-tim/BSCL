<?php
session_start();
include_once "./dbcon.php";
$mail = $_POST['username'];
$pass = $_POST['password'];

$query = "SELECT * FROM users.login where users.login.username='".$mail."';";
$answer = mysqli_query($conn, $query);
if(mysqli_num_rows($answer)>0){
    $row=$answer->fetch_row();
    if(sha1($pass)==$row[2]){
        $_SESSION["LoggedIn"]="True";
        header("Location: http://www.BuffaloScholasticChessLeague.com/admin/home.php");
    } else{
        header("Location: http://www.BuffaloScholasticChessLeague.com/admin/");
        echo "<script>alert('Incorrect Username or Password.')</script>";
    }
} else{
    echo "Incorrect Username or Password.";
}