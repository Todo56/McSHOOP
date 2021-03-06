<?php
session_start();
include "auth.php";
if(!isset($_GET["pid"]) || !isset($_GET["user"])){
    header("Location: $base");
}
include"./utils/DatabaseManager.php";
$db = new DatabaseManager($con_settings);
$res = $db->query("SELECT * FROM products WHERE id=?", "i", [intval($_GET["pid"])]);
$image = $res[0]["image"]
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script
        src="https://www.paypal.com/sdk/js?client-id=<?php echo ($sandbox === true) ? $paypal_app_client_id_sandbox : $paypal_app_client_id;?>">
    </script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <!-- <link href="./assets/css/style.css" rel="stylesheet"> -->
    <style type="text/css">
        body {
            padding-top: 56px;
            background-color: #151618!important;
            color: white !important;
            height: 100%;
        }
        nav, footer {
            background-color: #181a1b!important;
        }
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
        .fade-out {
            opacity: 0;
            animation-name: fadeInOpacity;
            animation-iteration-count: 1;
            animation-timing-function: ease-in;
            animation-duration: 1s;
        }

        .fade-in {
            opacity: 1;
            animation-name: fadeOutOpacity;
            animation-iteration-count: 1;
            animation-timing-function: ease-in;
            animation-duration: 1s;
        }

        @keyframes fadeInOpacity {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        @keyframes fadeOutOpacity {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="d-flex flex-column sticky-footer-wrapper" style="position: relative;">
<div class="login-form text-center" style="position: absolute;     top:calc(50% - 15px);
    left:calc(50% - 50px);
    height:30px;
    width:200px;">
    <div id="load"></div>
</div>
<!-- Navigation -->
<?php require("./assets/partials/navbar.php"); ?>
<div id="body" >
    <!-- Page Content -->
    <div class="login-form">
        <div class="card bg-success" style="">
            <div class="card-body">
                <h5 class="card-title"><?php echo $res[0]["name"];?></h5>
                <b>&dollar;<?php echo $res[0]["price"]?></b>
                <p class="card-text">Thank you for buying in our shop! Your product has been added in-game.</p>
                <a class="btn btn-success" href="<?php echo $base; ?>">Go Home</a>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark " style="background-color: #181a1b!important;">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; <?php echo $shop_name; ?> 2020</p>
        </div>
        <!-- /.container -->
    </footer>
</div>



</body>

</html>
