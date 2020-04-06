<?php
if(isset($_SESSION["user"])){
    header("Location: /index.php");
}
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["username"])){
        $_SESSION["username"] = $_POST["username"];
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
    </label>
</form>
</body>
</html>
