<?php
error_reporting(0);

include ("../config.php");
include ("../utils/DatabaseManager.php");
$db = new DatabaseManager($con_settings);
$error = "";
session_start();
if(!isset($_GET["type"])){
    header("Location: $base");
}
include ("./dashauth.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.rawgit.com/adriancooney/console.image/c9e6d4fd/console.image.min.js"></script>
    <script>
        console.image("https://todo56.dev/assets/images/stop.png");
        console.info("Changing the javascript or html of this site could fuck up your purchase. Unless you know what you're doing just close this.");
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $shop_name; ?></title>
    <script
            src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
            crossorigin="anonymous"></script>
    <!-- Bootstrap core CSS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style type="text/css">
        .login-form {
            width: 340px;
            margin: 50px auto;
        }
        .login-form form {
            margin-bottom: 15px;
            background-color: #181a1b!important;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 5px;
        }
        .login-form h2 {
            margin: 0 0 15px;
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 2px;
        }
        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
<?php require("../assets/partials/navbar.php");
$dashboard = $base . "dashboard";
?>
<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
switch ($_GET["type"]){
    case "category":
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST["name"]) && isset($_POST["description"])){
                if(strlen($_POST["name"]) < 50){
                    $name = $_POST["name"];
                    $description = $_POST["description"];
                    $db->insert("INSERT INTO categories (name, description) VALUES (?, ?)", "ss", [$name, $description]);
                    echo "<script>
                        window.location = '$dashboard'
                    </script>";
                } else {
                    $error = "Name is too long";
                }
            } else {
                $error = "Invalid Request";
            }
        }
        echo "<div class=\"login-form\">
    <form method=\"post\">
        <h2 class=\"text-center\">Create Category</h2>
        <div class=\"form-group\">
            <input type=\"text\" class=\"form-control\" placeholder=\"My Category\" name=\"name\" required=\"required\">
        </div>
        <div class=\"form-group\">
            <textarea name='description' placeholder='My category is a very nice category indeed.' required class=\"form-control\"></textarea>
        </div>
        <div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-block\">Create</button>
        </div>
        <div class=\"clearfix\">
            <?php  echo $error;?>
        </div>
    </form>
</div>";
        break;
    case "product":
        $res = $db->select("SELECT * FROM servers");
        $res1 = $db->select("SELECT * FROM categories");
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["command"]) && isset($_POST["server"]) && isset($_POST["category"])){
                if(strlen($_POST["name"]) > 50){
                    $error = "Name is too long";

                } else if(strlen($_POST["command"]) > 100){
                    $error = "Command is too long";
                } else {

                    $name = $_POST["name"];
                    $description = $_POST["description"];
                    $price = floatval($_POST["price"]);
                    $command =  $_POST["command"];
                    $server = intval($_POST["server"]);
                    $category = intval($_POST["category"]);
                    $author = intval($_SESSION["user_id"]);
                    if($_FILES["image"]){
                        $target_dir = "../assets/images/";
                        $target_file = $target_dir . basename($_FILES["image"]["name"]);
                        if (file_exists($target_file)) {
                            $target_file = $target_dir . generateRandomString() . ".".pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                        } else {
                            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                        }
                    }
                    $db->insert("INSERT INTO products(name, description, price, command, category, server, author, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", "ssdsiiis", [$name, $description, $price, $command, $category, $server, $author, $target_file]);
                    echo "<script>
                        window.location = '$dashboard'
                    </script>";
                }
            } else {
                $error = "Invalid Request";
            }
        }
        echo "<div class=\"login-form\">
    <form method=\"post\" enctype=\"multipart/form-data\">
        <h2 class=\"text-center\">Create Product</h2>
        <div class=\"form-group\">
        Name:
            <input type=\"text\" class=\"form-control\" placeholder=\"My Product\" name=\"name\" required>
        </div>
        <div class=\"form-group\">
        Description:
            <textarea name='description' placeholder='This product is very nice! You should probably buy it.' required class=\"form-control\"></textarea>
        </div>
        <div class=\"form-group\">
             Price:
             <input type=\"number\" class=\"form-control\" required name=\"price\" min=\"0\" value=\"0\" step=\".01\">
        </div>
               <div class=\"form-group\">
               Product Image: <small>Optional</small>
            <input type='file' class='form-control' name='image' id='image'>
        </div>
        <div class=\"form-group\">
            Command:
            <textarea name='command' placeholder='setgroup {{player}} Rank' required class=\"form-control\"></textarea>
            <small>{{player}} is the player's name.</small>
        </div>
        <div class=\"form-group\">
        Server to execute this on:
                     <select class='form-control' name='server'>
                                  <option value='0'>All</option>
         ";
        while($row = $res->fetch_assoc()){
            $ip = $row["host"];
            $port = $row["port"];
            $id = $row["id"];
            echo "<option value='$id'>$ip:$port</option>";
        }
        echo "
             </select>
        </div>
        <div class='form-group'>
        Category:
        <select name='category' class='form-control'>
        ";
        while($row = $res1->fetch_assoc()){
            $name = $row["name"];
            $id = $row["id"];
            echo "<option value='$id'>$name</option>";
        }
        echo "
</select>
        </div>
        <br>
        <div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-block\">Create</button>
        </div>
        <div class=\"clearfix\">
            <?php  echo $error;?>
        </div>
    </form>
</div>";
        break;
    case "server":
        echo "
        
        <div class=\"login-form\">
    <form method=\"post\">
        <h2 class=\"text-center\">Create Server</h2>
        <div class=\"form-group\">
            Host:
            <input type=\"text\" class=\"form-control\" placeholder=\"127.0.0.1\" name=\"host\" required>
        </div>
                <div class=\"form-group\">
                Port:
            <input type=\"number\" class=\"form-control\" placeholder=\"19132\" name=\"port\" required>
        </div>
        <div class=\"form-group\">
        Password:
                    <input type=\"password\" class=\"form-control\" placeholder=\"Password\" name=\"password\" required>
        </div><br>
        <div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-block\">Create</button>
        </div>
        <div class=\"clearfix\">
            <?php  echo $error;?>
        </div>
    </form>
</div>
        ";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["host"]) && isset($_POST["port"]) && isset($_POST["password"])){
                require("../utils/Rcon.php");
                $rcon = new Rcon($_POST["host"], $_POST["port"], $_POST["password"], 3);
                try {
                    if($rcon->testserver()){
                        $db->insert("INSERT INTO servers (host, port, password) VALUES(?, ?, ?)", "sss", [$_POST["host"], $_POST["port"], $_POST["password"]]);
                        echo "<script>
                        window.location = '$dashboard'
                    </script>";
                    } else {
                        $error = "Couldn't connect to server.";
                    }
                } catch (Error $e){
                    $error = "Couldn't connect to server.";
                }
            } else {
                $error = "Invalid Request";
            }
        }
        break;
    case "user":
echo "
<div class=\"login-form\">
    <form method=\"post\">
        <h2 class=\"text-center\">Create User</h2>
        <div class=\"form-group\">
        Username:
            <input type=\"text\" class=\"form-control\" placeholder=\"Todo56\" name=\"username\" required>
        </div>
        <div class=\"form-group\">
        Password:
            <input type=\"password\" class=\"form-control\" placeholder=\"Password\" name=\"password\" required>
        </div>
        <div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-block\">Create</button>
        </div>
        <div class=\"clearfix\">
            <?php  echo $error;?>
        </div>
    </form>
</div>";
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST["username"]) && isset($_POST["password"])){
                if(strlen($_POST["username"]) < 30){
                    $name = $_POST["username"];
                    $description = hash('sha512', $_POST["password"]);
                    $db->insert("INSERT INTO users (username, password) VALUES (?, ?)", "ss", [$name, $description]);
                    echo "<script>
                        window.location = '$dashboard'
                    </script>";
                } else {
                    $error = "Username is too long";
                }
            } else {
                $error = "Invalid Request";
            }
        }
        break;
    default:
        echo "<script>
                        window.location = '$dashboard'
                    </script>";
        break;
}
?>
    <footer class="py-5 bg-dark" style="background-color: #181a1b!important;">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; <?php echo $shop_name; ?> 2020</p>
        </div>
        <!-- /.container -->
    </footer>


</body>

</html>
