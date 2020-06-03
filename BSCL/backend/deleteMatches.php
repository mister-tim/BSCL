<?php
session_start();
if($_SESSION["LoggedIn"]!="True"){
    header("Location: http://www.BuffaloScholasticChessLeague.com");
}
include "scripts/dbcon.php";

$Games = [];

$MatchQuery = "SELECT * FROM Matches.game;";
$Launch = mysqli_query($conn, $MatchQuery);
while($row = $Launch->fetch_row()){
  array_push($Games, $row);
}
?>
<script>
  var GList = <?php echo json_encode($Games) ?>;
  var modalopen = false;
  console.log(GList[0]);
  if(!localStorage.getItem("GameList")){
    localStorage.setItem("GameList", GList);
  }
    
</script>
<?php
include "components/Delete.html";
?>