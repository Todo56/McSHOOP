<?php
session_start();
include "../utils/DatabaseManager.php";
include "../config.php";
include "./dashauth.php";
if(isset($_GET["id"]) && isset($_GET["type"])){
    $table = "";
    $type = $_GET["type"];
    switch ($type){
        case "product":
            $table = "products";
            break;
        case "server":
            $table = "servers";
            break;
        case "category":
            $table = "categories";
            break;
        case "user":
            $table = "users";
            break;
        default:
            header("Location: $base");
            break;
    }
    $stat = 1;
    if($table !== ""){
        $id = intval($_GET["id"]);
        $con = new mysqli($con_settings[0], $con_settings[1], $con_settings[2], $con_settings[3]);
        if($table === "products"){
            $res = $db->select("SELECT * FROM products WHERE id=$id");
            $row = $res->fetch_assoc();
            $image = $row["image"];
            unlink("$image");
        }
        if($table === "servers") {
            $r = $con->query("SELECT * FROM products WHERE server=$id");
            if ($r->num_rows !== 0) {
                $stat = 0;
                header("Location: $base" . "dashboard?error=1&message=A server cannot be deleted if its linked to a product.");
            }
        }
        if($stat === 1){
            $con->query("DELETE FROM $table WHERE id=$id");
            header("Location: $base" . "dashboard?error=0&message=$type has been deleted successfully!");
        }
    }
} else {
header("Location: $base");
}