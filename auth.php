<?php
require("./config.php");
if(!isset($_SESSION["username"])){
    $r = $base . "login.php";
    header("Location: $r");
}