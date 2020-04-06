<?php
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
    default:
        header("Location: /index.php");
        break;
}