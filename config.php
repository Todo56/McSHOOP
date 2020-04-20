<?php
/*
 * You must run config.sql before doing anything.
 */

// DATABASE SETTINGS:
$con_settings = ["localhost", "root", "64466446Gg", "mcpeshoop"];

// DOMAIN SETTINGS:
$base = "/McpeSHOOP/";
$shop_name = "EndGames Shop";
$weburl = "http://localhost/McpeSHOOP";
$returnurl = $weburl . "/success"; // Do not touch unless you know what you're doing.
$cancelurl = $weburl . "/cancel"; // Do not touch unless you know what you're doing.
$notiftyurl = $weburl . "/api/index.php"; // Do not touch unless you know what you're doing.

// PAYMENT SETTINGS:
$currency_code = "USD"; // Do not touch unless you know what you're doing.
$paypal_account_email = "sb-2pyb71400016@business.example.com";
$paypal_app_client_id = "AQUCduBZucFlomnfRRoZAMwf1UDKobVl8JUR1QQA4lXOpE3GKps4lRB7kOVb38-S5eAaxsaYtaSEbK-T";
$paypal_app_client_id_sandbox = "AQuygMvKooua8NOUloHhoENCme9o5XoFkM7ZzpMVKBuft_Ir3mHs7FA23Nyv7D3pHyw-_VHsSdaWHuP4";
$paypal_app_client_secret = ""; // DO NOT EVER SHARE!
$paypal_app_client_secret_sandbox = "EBYU6OMvklLwaNU9eWqXv3CO3aetIqz1QQoT2nYyvfEt2K5Lz3T3AXf6T019N8kSZoT2DhhIPf4fzui3"; // DO NOT EVER SHARE!
$sandbox = true; // Be careful when running with this value set to false. We're playing with real money right there.
$paypal_url = ($sandbox === true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr"; // Do not touch unless you know what you're doing.

// SERVER SETTINGS:
$allow_broadcast_message = true; // Whether a message should be broadcasted to the server when someone buys something. (Requires our plugin).
$broadcast_message = "{{player}} bough the product {{product}} off of our store running McpeSHOOP that has a value of {{price}}!"; // The variable {{player}} replaces the player's ign, {{product}} replaces the product's name and {{price}} the products price.
$dologs = true; // Whether to create logs of everything that goes or does not go good in the log.txt file.