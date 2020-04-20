<?php
/*
 * You must run config.sql before doing anything.
 */

// DATABASE SETTINGS:
$con_settings = ["127.0.0.1", "root", "root", "mcpeshoop"];

// DOMAIN SETTINGS:
$base = "/McpeSHOOP/";
$shop_name = "Mcpe Shop";
$weburl = "http://127.0.0.1/McpeSHOOP";
$returnurl = $weburl . "/success"; // Do not touch unless you know what you're doing.
$cancelurl = $weburl . "/cancel"; // Do not touch unless you know what you're doing.
$notiftyurl = $weburl . "/api/index.php"; // Do not touch unless you know what you're doing.

// PAYMENT SETTINGS:
$currency_code = "USD"; // Do not touch unless you know what you're doing.
$paypal_account_email = "business@email.com";
$paypal_app_client_id = "mypaypalclient";
$paypal_app_client_id_sandbox = "mypaypalclientsandbox";
$paypal_app_client_secret = "mypaypalsecret"; // DO NOT EVER SHARE!
$paypal_app_client_secret_sandbox = "mypaypalsecretsandbox"; // DO NOT EVER SHARE!
$sandbox = true; // Be careful when running with this value set to false. We're playing with real money right there.
$paypal_url = ($sandbox === true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr"; // Do not touch unless you know what you're doing.

// SERVER SETTINGS:
$allow_broadcast_message = true; // Whether a message should be broadcasted to the server when someone buys something. (Requires our plugin).
$broadcast_message = "{{player}} bough the product {{product}} off of our store running McpeSHOOP that has a value of {{price}}!"; // The variable {{player}} replaces the player's ign, {{product}} replaces the product's name and {{price}} the products price.
$dologs = true;
