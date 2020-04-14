
<?php
$login = $base . "dashboard/login";
if(isset($_SESSION["user"]) && isset($_SESSION["password"])){
    $password = $_SESSION["password"];
    $user = $_SESSION["user"];
    $db = new DatabaseManager($con_settings);
    $res = $db->query("SELECT * FROM users WHERE username=? AND password=?", "ss", [$user, $password]);
    if(count($res) < 1){
        header("Location: $login");
    }
} else {
    header("Location: $login");
}