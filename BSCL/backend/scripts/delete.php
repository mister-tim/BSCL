<?php
include "./dbcon.php";
$selected = json_decode(file_get_contents('php://input'));
$failed = -1;
$qBase = "DELETE FROM Matches.game WHERE Matches.game.id=";
for($i = count($selected)-1; $i>-1; $i--){
    $qFull = $qBase.$selected[$i];
    if(!$Launch = mysqli_query($conn, $qFull)){
        $failed = $i;
    break;
    }
}
if($failed >= 0){
    echo "Error removing row ".$failed;
} else{
    echo "Green";
}