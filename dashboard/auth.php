
<?php
include ("../config.php");
$login = $base . "dashboard/login";
if(isset($_SESSION["user"]) && isset($_SESSION["password"])){
    $password = $_SESSION["password"];
    $user = $_SESSION["user"];
    $res = $con->query("SELECT * FROM users WHERE username='$user' AND password='$password'");
    if($res->num_rows < 1){
        header("Location: $login");
    }
} else {
    header("Location: $login");
}