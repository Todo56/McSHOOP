<?php
$error = "";
session_start();
require ("../../config.php");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["user"]) && isset($_POST["password"])){
        $password = hash('sha512', $_POST['password']);
        $user = $_POST["user"];
        $res = $con->query("SELECT * FROM users WHERE username='$user' AND password='$password'");
        if($res->num_rows < 1){
            $error = "Invalid Credentials";
        } else {
            $_SESSION["user"] = $user;
            $_SESSION["password"] = $password;
            $dashboard = $base . "dashboard";
            header("Location: $dashboard");
        }
    } else {
        $error = "Invalid Request";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

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
    <link href="../../assets/css/style.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<?php require("../../assets/partials/navbar.php"); ?>

<!-- Page Content -->
<div class="container">
    <form method="post">

        <div class="form-group">
            <label>
                Username:
                <input class="form-control" type="text" name="user">
            </label>
        </div>
        <div class="form-group">
            <label>
                Password:
                <input class="form-control" type="password" name="password">
            </label>
        </div>
        <?php echo $error;?>
        <input class="btn btn-primary" type="submit">
    </form>
</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark" style="background-color: #181a1b!important;">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; <?php echo $shop_name; ?> 2020</p>
    </div>
    <!-- /.container -->
</footer>


</body>

</html>
