<?php
include "./dbcon.php";
$submitted = json_decode(file_get_contents('php://input'));
$DateFixer = explode("-", $submitted[0]);
$Date = $DateFixer[1]."-".$DateFixer[2]."-".$DateFixer[0];
$qBase = "INSERT INTO Matches.game (day, matchup, PlayerA, ScoreA, PlayerB, ScoreB) VALUES ";
for($i = 1; $i<count($submitted);$i++){
    $Match = $submitted[$i][0]."|".$submitted[$i][1];
    $Sorter = explode("|", $submitted[$i][2]);
    $Games = [];
    for($ii = 0; $ii<count($Sorter);$ii++){
        array_push($Games, explode(";", $Sorter[$ii]));
    }
    for($ii = 0; $ii<count($Games);$ii++){
        if($ii == 0 && $i == 1){
            $qBase .= "('".$Date."','".$Match."','".$Games[$ii][0]."','".$Games[$ii][1]."','".$Games[$ii][2]."','".$Games[$ii][3]."')";
        } else{
            $qBase .= ", ('".$Date."','".$Match."','".$Games[$ii][0]."','".$Games[$ii][1]."','".$Games[$ii][2]."','".$Games[$ii][3]."')";
        }
    }
}
$qBase .= ";";
if($Launch = mysqli_query($conn, $qBase)){
    echo "Green";
} else{
    echo $qBase;
}