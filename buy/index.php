<?php
include "../auth.php";
if(!isset($_GET["pid"])){
    header("Location: $base");
} else {
    $pid = $_GET["pid"];
    $res = $con->query("SELECT * FROM products WHERE id=$id");
    if($res->num_rows === 0){
        header("Location: $base");
    }
}