<?php
session_start();
if(isset($_SESSION["username"])){
    header("Location: /index.php");
}
include ("../config.php");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["username"])){
        $r = $base . "index.php";
        $_SESSION["username"] = $_POST["username"];
        header("Location: $r");
    }
}
?>
<html lang="en">
<head>
    <title>Login - MCPESHOOP</title>
</head>
<body>
<form method="post">
    <label>
        Minecraft Username:
        <input type="text" name="username" required value="Steve">
        <input type="submit">
    </label>
</form>
</body>
</html>
