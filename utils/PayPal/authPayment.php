<?php
if(!isset($_POST["id"])){
    return '{"error": true, "message": "And invalid request was attempted."}';
}
include "./PayPal.php";
include "../../config.php";
$p = new PayPal($sandbox);
$creds = ($sandbox === true) ? [$paypal_app_client_id_sandbox, $paypal_app_client_secret_sandbox] : [$paypal_app_client_id, $paypal_app_client_secret];
$token = $p->getToken($creds[0], $creds[1]);
$res = $p->checkPayment($_POST["id"], $token);
if($res){
    echo '{"error": false, "message": "Success!"';
} else {
    echo '{"error": true, "message": "Invalid PaymentID."';
}