<?php
/*
 * You must run config.sql before doing anything.
 */
$con_settings = ["localhost", "root", "64466446Gg", "mcpeshoop"];
$base = "/McpeSHOOP/";
$shop_name = "EndGames Shop";
$weburl = "http://localhost/McpeSHOOP";
$returnurl = $weburl . "/success";
$cancelurl = $weburl . "/cancel";
$notiftyurl = $weburl . "/api/index.php";
$currency_code = "USD";
$paypal_account_email = "sb-2pyb71400016@business.example.com";
$paypal_app_client_id = "AQUCduBZucFlomnfRRoZAMwf1UDKobVl8JUR1QQA4lXOpE3GKps4lRB7kOVb38-S5eAaxsaYtaSEbK-T";
$paypal_app_client_id_sandbox = "AQuygMvKooua8NOUloHhoENCme9o5XoFkM7ZzpMVKBuft_Ir3mHs7FA23Nyv7D3pHyw-_VHsSdaWHuP4";
$sandbox = true;
$paypal_url = ($sandbox === true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr";