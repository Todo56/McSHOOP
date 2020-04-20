<?php
session_start();
if(isset($_SESSION["username"])){
    header("Location: /index.php");
}
include ("./config.php");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["username"])){
        $r = $base . "index.php";
        $_SESSION["username"] = $_POST["username"];
        header("Location: $r");
    }
}
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
    <link href="./assets/css/style.css" rel="stylesheet">
    <style type="text/css">
        .login-form {
            width: 340px;
            margin: 50px auto;
        }
        .login-form form {
            margin-bottom: 15px;
            background-color: #181a1b!important;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
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
<?php require("./assets/partials/navbar.php"); ?>

<!-- Page Content -->
<div class="login-form">
    <form method="post">
        <h2 class="text-center">Log in</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Minecraft Username" name="username" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
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