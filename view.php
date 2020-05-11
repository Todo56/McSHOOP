<?php
session_start();
require ("./auth.php");
if(!isset($_GET["pid"])){
    header("Location: $base");
}
$pid= $_GET["pid"];
include("./utils/DatabaseManager.php");
include("./utils/Parsedown.php");
$db = new DatabaseManager($con_settings);
$res = $db->select("SELECT * FROM products WHERE id=$pid");
if($res->num_rows === 0){
    header("Location: $base");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://cdn.rawgit.com/adriancooney/console.image/c9e6d4fd/console.image.min.js"></script>
    <script>
        console.image("https://todo56.dev/assets/images/stop.png");
        console.info("Changing the javascript or html of this site could fuck up your purchase. Unless you know what you're doing just close this.");
    </script>
    <title><?php echo $shop_name; ?></title>
    <script
            src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
            crossorigin="anonymous"></script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Custom styles for this template -->

    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .jumbotron{
            background-color: #080808;
        }
    </style>
</head>

<body>

<!-- Navigation -->
<?php require("./assets/partials/navbar.php"); ?>

<!-- Page Content -->
<?php
$row = $res->fetch_assoc();
$id = $row["id"];
$name = $row["name"];
$description = $row["description"];
$price = $row["price"];
$image = substr($row["image"], 3);
$category = $row["category"];
$longdes = $row["long_description"];
$res1 = $db->select( "SELECT * FROM categories WHERE id=$category");
if($res->num_rows === 0){
    $cat = "<span class=\"badge badge-danger\">Deleted</span>";
} else {
    $row11 = $res1->fetch_assoc();
    $s = $row11["name"];
    $cat = "<span class=\"badge badge-success\">$s</span>";
}
$buy = $base . "checkout?id=" . $row["id"];
?>
<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-3">
            <h2>Purchases:</h2>
            <?php
            $res2 = $db->select("SELECT * FROM payments WHERE pid=$id");
            echo "This product has been purchased " . $res2->num_rows . " times.";
            ?>
            <hr class="d-sm-none">
        </div>
        <div class="col-sm-9">


            <br>
            <div class="card">
                <img class="card-img-top" src="<?php echo $image; ?>" alt="ss">
                <div class="card-header list-inline">

                        <h2 class=" list-inline-item"><?php echo $name; ?></h2>
                        <h4 class="text-right align-right list-inline-item" >&dollar;<?php echo $price; ?></h4>

                    <p><?php echo $cat;?></p>
                    <h5><?php echo $description;?></h5>
                </div>

                <div class="card-body">
                    <?php if($longdes !== null){
                        $parser = new Parsedown();
                        $parser->setMarkupEscaped(true);
                        echo $parser->text($longdes); # prints: <p>Hello <em>Parsedown</em>!</p>
                    } else {
                        echo "No more details provided";
                    }?>
                </div
                <div class="card-footer">
                    <a class="btn btn-success" href="./buy.php?pid=<?php echo $pid;?>">Buy</a>

                </div>
            </div>

        </div>
    </div>
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


