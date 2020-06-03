<?php
include "./dbcon.php";

$UnsortedAnswer = [];
$UnsortedIndex = [];
$UnsortedSeasons = [];
$SortedAnswer = [];

//Pull Matches DB info into UnsortedAnswer Array.
$MatchQuery = "SELECT * FROM Matches.game;";
$Launch = mysqli_query($conn, $MatchQuery);
while($row = $Launch->fetch_row()){
    $newrow = [];
    for($i=1;$i<count($row);$i++){
        array_push($newrow, $row[$i]);
    }
    array_push($UnsortedAnswer, $newrow);
}
//Loop through the UnsortedAnswer array. On each pass:
for($i=0;$i<count($UnsortedAnswer);$i++){
    //Declare iteration variables.
    $SeaIndex = $MeetIndex = $MatchIndex = -1;
    $Year = explode("-", $UnsortedAnswer[$i][0])[2];
    $Match = explode("|", $UnsortedAnswer[$i][1]);
    //Check if Meet Index exists for the year. If not create it and push it the Meet Pairing. Then Create the Season Array.
    for($ii = 0; $ii<count($UnsortedIndex);$ii++){
        if($UnsortedIndex[$ii][0][0] == $Year){
            $SeaIndex = $ii;
        }
    }
    if($SeaIndex < 0){
        //If Season doesn't exist create all necessary arrays and insert data from the row.
        $temp = [$Year, $UnsortedAnswer[$i][0]];
        array_push($UnsortedIndex, array($temp));
        array_push($UnsortedSeasons, 
        array(
            array(
                array(
                    array($Match[0]," ", $Match[1]," "),
                    array($UnsortedAnswer[$i][2], number_format($UnsortedAnswer[$i][3], 1), $UnsortedAnswer[$i][4], number_format($UnsortedAnswer[$i][5], 1))
                )
            )
        ));
    }else{
        //Check if Meet Pairing and Meet Array exist for curent date. If not create them.
        for($ii = 0; $ii<count($UnsortedIndex[$SeaIndex]);$ii++){
            if($UnsortedIndex[$SeaIndex][$ii][1] == $UnsortedAnswer[$i][0]){
                $MeetIndex = $ii;
            }
        }
        if($MeetIndex < 0){
            //If Meet Doesn't exist create all necessary arrays and insert data from the row.
            array_push($UnsortedIndex[$SeaIndex], array($Year, $UnsortedAnswer[$i][0]));
            array_push($UnsortedSeasons[$SeaIndex], 
            array(
                array(
                    array($Match[0]," ", $Match[1]," "),
                    array($UnsortedAnswer[$i][2], number_format($UnsortedAnswer[$i][3], 1), $UnsortedAnswer[$i][4], number_format($UnsortedAnswer[$i][5], 1))
                )
            ));
        } else{
            //Check if Matchup Array exists. If not create it.
            for($iii = 0; $iii<count($UnsortedSeasons[$SeaIndex][$MeetIndex]); $iii++){
                if($UnsortedSeasons[$SeaIndex][$MeetIndex][$iii][0][0] == $Match[0] && $UnsortedSeasons[$SeaIndex][$MeetIndex][$iii][0][2] == $Match[1]){
                    $MatchIndex = $iii;
                }
            }
            if($MatchIndex < 0){
                //If Match Doesn't exist create the array and insert data from the row.
                array_push($UnsortedSeasons[$SeaIndex][$MeetIndex],
                array(
                    array($Match[0]," ", $Match[1]," "),
                    array($UnsortedAnswer[$i][2], number_format($UnsortedAnswer[$i][3], 1), $UnsortedAnswer[$i][4], number_format($UnsortedAnswer[$i][5], 1))
                ));
            } else{
                array_push($UnsortedSeasons[$SeaIndex][$MeetIndex][$MatchIndex],
                array($UnsortedAnswer[$i][2], number_format($UnsortedAnswer[$i][3], 1), $UnsortedAnswer[$i][4], number_format($UnsortedAnswer[$i][5], 1)));
            }
        }
    }
}
//Loop through the UnsortedSeasons Array to get the Total Scores, on each pass:
for($seas = 0; $seas<count($UnsortedSeasons);$seas++){
    for($meet = 0; $meet<count($UnsortedSeasons[$seas]); $meet++){
        //Create the empty Totals array for each Meet.
        $Totals = [];
        for($mat = 0; $mat<count($UnsortedSeasons[$seas][$meet]); $mat++){
            //Determine the schools in question, and their indexes in the Totals array.
            $Schools = [];
            for($game = 0; $game<count($UnsortedSeasons[$seas][$meet][$mat]); $game++){
                if($game == 0){
                    array_push($Schools, array($UnsortedSeasons[$seas][$meet][$mat][0][0], -1));
                    array_push($Schools, array($UnsortedSeasons[$seas][$meet][$mat][0][2], -1));
                    //Set the School indexes. Make sure Park and ParkB count as the same.
                    for($i = 0; $i<count($Schools); $i++){
                        if($Schools[$i][0] == "ParkB"){
                            $Schools[$i][0] = "Park";
                        }
                        for($ii = 0; $ii<count($Totals); $ii++){
                            if($Schools[$i][0] == $Totals[$ii][0]){
                                $Schools[$i][1] = $ii;
                            }
                        }
                        if($Schools[$i][1] < 0){
                            $Schools[$i][1] = count($Totals);
                            array_push($Totals, array($Schools[$i][0], number_format(0, 1)));
                        }
                    }
                } else{
                    $Totals[$Schools[0][1]][1] = number_format($Totals[$Schools[0][1]][1] += $UnsortedSeasons[$seas][$meet][$mat][$game][1], 1);
                    $Totals[$Schools[1][1]][1] = number_format($Totals[$Schools[1][1]][1] += $UnsortedSeasons[$seas][$meet][$mat][$game][3], 1);
                }
            }
        }
        array_push($UnsortedSeasons[$seas][$meet], $Totals);
    }
}
//Insert (Un)SortedIndex into SortedAnswer.
array_push($SortedAnswer, $UnsortedIndex);
//Insert (Un)SortedSeason Elements into SortedAnswer in order..
for($i = 0; $i<count($UnsortedSeasons); $i++){
    array_push($SortedAnswer, $UnsortedSeasons[$i]);
}
//Echo SortedAnswer JSON.
echo json_encode($SortedAnswer);
?>