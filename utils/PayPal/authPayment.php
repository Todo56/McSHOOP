<?php
error_reporting(0);
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
        include "../DatabaseManager.php";
        $db = new DatabaseManager($con_settings);
        $id = intval($_POST["product_id"]);
        $check = $db->select("SELECT * FROM payments WHERE order_id='$id'");
        if($check->num_rows !== 0)
        {
            echo '{"error": true, "message": "Invalid Order ID."}';
        } else {
            $db->insert("INSERT INTO payments (pid, price, username, order_id) VALUES (?,?,?,?)", "idss", [$_POST["product_id"], $_POST["price"], $user, $_POST["id"]]);
            include "../Rcon.php";
            $product_query = $db->select("SELECT * FROM products WHERE id=$id");
            if($product_query->num_rows == 1){
                $row = $product_query->fetch_assoc();
                $command = str_replace("{{player}}", "$user", $row["command"]);
                if($row["server"] == 0){
                    $server_query = $db->select("SELECT * FROM servers");
                    while ($serverrow = $server_query->fetch_assoc()){
                        $rcon = new Rcon($serverrow["host"], intval($serverrow["port"]), $serverrow["password"], 3);
                        if($rcon->connect()){
                            $commands = explode(",", $command);
                            foreach($commands as $cmd){
                                $rcon->sendCommand($cmd);
                            }
                        }
                    }
                } else {
                    $srvid = intval($row["server"]);
                    $server_query = $db->select("SELECT * FROM servers WHERE id=$srvid");
                    if($server_query->num_rows !== 0){
                        $serverroww = $server_query->fetch_assoc();
                        $rcon = new Rcon($serverroww["host"], intval($serverroww["port"]), $serverroww["password"], 3);
                        if($rcon->connect()){
                            $commands = explode(",", $command);
                            foreach($commands as $cmd){
                                $rcon->sendCommand($cmd);
                            }
                        }
                    }
                }
                echo '{"error": false, "message": "The product has been added to $user!", "m": "The product has been added to ' . $user . '!"}';
            }
        }
    }
}

