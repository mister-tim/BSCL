<?php
session_start();
if($_SESSION["LoggedIn"]!="True"){
    header("Location: http://www.BuffaloScholasticChessLeague.com");
}