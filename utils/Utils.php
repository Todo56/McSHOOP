<?php
require("./Rcon.php");

function validateRcon($host, $port, $password, $timeout){
    $r = new Rcon($host, $port, $password, $timeout);
    return $r->connect();
}
function sendCommand($host, $port, $password, $timeout, $command){
    if(validateRcon($host, $port, $password, $timeout)){
        $r = new Rcon($host, $port, $password, $timeout);
        $r->sendCommand($command);
    } else {
        return false;
    }
}