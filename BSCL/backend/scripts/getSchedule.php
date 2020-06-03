<?php
include_once './dbcon.php';

$DBQ = "SELECT otherInfo.data.textblock FROM otherInfo.data Where otherInfo.data.title = 'Schedule';";
$launch = mysqli_query($conn, $DBQ);
$answer = $launch->fetch_row();
echo json_encode($answer[0]);