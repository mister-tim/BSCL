<?php
$server = "***";
$user = "***";
$passw = "***";
$db = "Matches";
// Attempt connection
$conn = mysqli_connect($server, $user, $passw, $db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>