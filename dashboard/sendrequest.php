<?php
error_reporting(0);
include "../utils/Log.php";
include("../utils/Rcon.php");
include "../config.php";
$log = new Log("../log.txt", $dologs);
if(isset($_POST["host"]) && isset($_POST["port"]) && isset($_POST["password"])){
    $host = $_POST["host"] . ":" . $_POST["port"];
    $rcon = new Rcon($_POST["host"], $_POST["port"], $_POST["password"], 3);
    if($rcon->connect()){
        $rcon->sendCommand("say HEY!");
        $log->create("Sent successful test request to $host.", 1);
        echo '{"error": 0, "message": "Server responded!"}';
    } else {
        $log->create("Sent failed test request to $host.", 3);
        echo '{"error": 1, "message": "Could not connect to the server."}';
    }
} else {
    echo '{"error": 1, "message": "Invalid request."}';
}
