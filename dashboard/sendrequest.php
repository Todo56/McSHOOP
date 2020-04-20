<?php
error_reporting(0);
include("../utils/Rcon.php");
if(isset($_POST["host"]) && isset($_POST["port"]) && isset($_POST["password"])){
    $rcon = new Rcon($_POST["host"], $_POST["port"], $_POST["password"], 3);
    if($rcon->connect()){
        $rcon->sendCommand("say HEY!");
        echo '{"error": 0, "message": "Server responded!"}';
    } else {
        echo '{"error": 1, "message": "Could not connect to the server."}';
    }
} else {
    echo '{"error": 1, "message": "Invalid request."}';
}
