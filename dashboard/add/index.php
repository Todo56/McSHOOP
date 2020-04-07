<?php
session_start();
switch ($_GET["type"]){
    case "category":
        echo "category";
        break;
    case "product":
        echo "product";
        break;
    case "server":
        echo "server";
        break;
    case "user":
        echo "user";
        break;
    default:
        header("Location: /index.php");
        break;
}