<?php
session_start();
require ("./auth.php");
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

</head>

<body>

  <!-- Navigation -->
<?php require("./assets/partials/navbar.php"); ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4"><?php echo $shop_name; ?></h1>
        <div class="list-group">
            <?php
            include("./utils/DatabaseManager.php");
            $db = new DatabaseManager($con_settings);
            $res = $db->select("SELECT * FROM categories");
            while($row = $res->fetch_assoc()){
                $id = $row["id"];
                $name = $row["name"];
                echo "
                <a href=\"?category=$id\" class=\"list-group-item\" style='background: #080808'>$name</a>
                ";
            }
            ?>
        </div>
          <br>
          <h1 class="my-4">Recent Purchases:</h1>

          <?php
          $res2 = $db->select("SELECT * FROM payments ORDER BY bought_at DESC LIMIT 10");
          while($row = $res2->fetch_assoc()){
              $name = $row["username"];
              $money = $row["price"];
              $pid = $row["pid"];
              $res3 = $db->select("SELECT * FROM products WHERE id=$pid");
              if($res3->num_rows === 0){
                  $text = "$name bought a deleted product. (&dollar;$money)";
              } else {
                  $row1 = $res3->fetch_assoc();
                  $product = $row1["name"];
                  $text = "$name bought <b>$product</b>. (&dollar;$money)";
              }
              echo "
              <div class=\"card\" style=\"width: 15rem;\">
  <div class=\"card-header\">
    $text
  </div>
</div><br>";
          }
          ?>
      </div>
      <!-- /.col-lg-3 -->
      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">
            <?php
            if(isset($_GET["category"])){
                $num = intval($_GET["category"]);
                $res = $db->select( "SELECT * FROM products WHERE category=$num");
            } else {
                $res = $db->select( "SELECT * FROM products");
            }
            while($row = $res->fetch_assoc()){
                $id = $row["id"];
                $name = $row["name"];
                $description = $row["description"];
                $price = $row["price"];
                $image = substr($row["image"], 3);
                $category = $row["category"];
                $res1 = $db->select( "SELECT * FROM categories WHERE id=$category");
                if($res->num_rows === 0){
                    $cat = "<span class=\"badge badge-danger\">Deleted</span>";
                } else {
                    $row11 = $res1->fetch_assoc();
                    $s = $row11["name"];
                    $cat = "<span class=\"badge badge-success\">$s</span>";
                }
                $buy = $base . "checkout?id=" . $row["id"];
                echo "
           <div class=\"col-lg-4 col-md-6 mb-4\">
            <div class=\"card h-100\">
              <a href=\"./view.php?pid=$id\"><img class=\"card-img-top\" src=\"$image\" alt=\"\"></a>
              <div class=\"card-body\">
                <h4 class=\"card-title\">
                  <a href=\"/view.php?pid=$id\">$name</a>
                </h4>
                <h5>&dollar;$price</h5>
                $cat
                <p class=\"card-text\">$description</p>
                <a class='btn btn-success' href=\"./buy.php?pid=$id\">Buy</a>
                <a class='btn btn-warning' href=\"./view.php?pid=$id\">Read More</a>

                </div>
              <div class=\"card-footer\">
                <!-- <small class=\"text-muted\">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
              </div>
            </div>
          </div>
                ";
            }
            ?>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
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