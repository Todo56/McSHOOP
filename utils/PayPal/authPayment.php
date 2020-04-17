<?php
session_start();

if(!isset($_POST["id"])){
    echo '{"error": true, "message": "Invalid Request."}';
} else {
    include "./PayPal.php";
    include "../../config.php";
    $p = new PayPal($sandbox);
    $creds = ($sandbox === true) ? [$paypal_app_client_id_sandbox, $paypal_app_client_secret_sandbox] : [$paypal_app_client_id, $paypal_app_client_secret];
    $token = $p->getToken($creds[0], $creds[1]);
    $res = $p->checkPayment($_POST["id"], $token, $_POST["link"]);
    if(!isset($res->id)){
        echo '{"error": true, "message": "Invalid Order ID."}';
    } else {
        $user = $_SESSION["username"];
        echo '{"error": false, "message": "The product has been added to $user!", "m": "The product has been added to ' . $user . '!"}';
        file_put_contents("../../log.txt", json_encode($res));
    }
}

