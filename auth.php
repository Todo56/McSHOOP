<?php

require("./config.php");
if(!isset($_SESSION["username"])){
    echo $_SESSION["username"];

    $r = $base . "login";
    header("Location: $r");
}