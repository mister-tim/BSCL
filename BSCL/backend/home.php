<?php
session_start();
if($_SESSION["LoggedIn"]!="True"){
    if($_SESSION["LoggedIn"]!="True"){
        header("Location: http://www.BuffaloScholasticChessLeague.com");
    } 
} 
?>
<h1>Get Started:</h1>
<ul>
    <li><a href="/admin/editSchedule.php">Edit Schedule</a></li>
    <li><a href="/admin/editMatches.php">Add Match Data</a></li>
    <li><a href="/admin/deleteMatches.php">Delete Match Data</a></li>
    <li><a href="/admin/editPhotos.php">Edit Photo Albums</a></li>
</ul>
<script>
    function cacheMatches(){
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://www.BuffaloScholasticChessLeague.com/admin/scripts/getMatchHistory.php");
        xhttp.send();    
        xhttp.onreadystatechange= function(){    
            if(xhttp.readyState==4 && xhttp.status==200){
                var ff = xhttp.response;        
                localStorage.setItem("MatchHistory", ff);        
            }                
        }    
    }
    function cacheSchedule(){
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://www.BuffaloScholasticChessLeague.com/admin/scripts/getSchedule.php");
        xhttp.send();    
        xhttp.onreadystatechange= function(){    
            if(xhttp.readyState==4 && xhttp.status==200){
                var ff = xhttp.response;        
                localStorage.setItem("Schedule", ff);        
            }                
        }    
    }
    function cacheData(){
        this.cacheMatches();
        this.cacheSchedule();
    }   
    cacheData();             
</script>