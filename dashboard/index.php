<?php
session_start();
include "../config.php";
include"../utils/DatabaseManager.php";
include "dashauth.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $shop_name; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Custom styles for this template -->

    <link href="../assets/css/style.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<?php require("../assets/partials/navbar.php"); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3">

            <h1 class="my-4"><?php echo $shop_name; ?></h1>
            <div class="row">
                <?php
                $db = new DatabaseManager($con_settings);
                $res = $db->select("SELECT * FROM categories");
                while($row = $res->fetch_assoc()){
                    $id = $row["id"];
                    $name = $row["name"];
                    echo "
<div class=\"card\" style=\"width: 18rem;\">
  <div class=\"card-header\">
    $name
  </div>
  <div class='card-body'>
                  <div class=\"dropdown\">
  <button class=\"btn btn-warning dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Actions
  </button>
  <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
    <a class=\"dropdown-item btn btn-danger\" href=\"./delete.php?id=$id&type=category\">Delete</a>
    <a class=\"dropdown-item\" href=\"./edit.php?id=$id&type=category\">Edit</a>
  </div>
</div>
</div>
</div><br>
                ";
                }
                ?>
            </div>
        </div>
        <!-- /.col-lg-3 -->
        <div class="col-lg-9">
            <div class="row">
                <?php
                    $res = $db->select( "SELECT * FROM products");

                while($row = $res->fetch_assoc()){
                    $id = $row["id"];
                    $name = $row["name"];
                    $description = $row["description"];
                    $price = $row["price"];
                    $image = $row["image"];
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
              <a href=\"#\"><img class=\"card-img-top\" src=\"$image\" alt=\"\"></a>
              <div class=\"card-body\">
                <h4 class=\"card-title\">
                  <a href=\"#\">$name</a>
                </h4>
                <h5>&dollar;$price</h5>
                $cat
                <p class=\"card-text\">$description</p>
                <div class=\"dropdown\">
  <button class=\"btn btn-warning dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Actions
  </button>
  <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
    <a class=\"dropdown-item btn btn-danger\" href=\"./delete.php?id=$id&type=product\">Delete</a>
    <a class=\"dropdown-item\" href=\"./edit.php?id=$id&type=product\">Edit</a>
  </div>
</div>
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
        </div>

    </div>
    <div class="row">
            <?php
            $res = $db->select( "SELECT * FROM servers");

            while($row = $res->fetch_assoc()){
                $id = $row["id"];
                $name = $row["host"];
                $port = $row["port"];
                $password = $row["password"];

                echo "
           <div class=\"col-lg-4 col-md-6 mb-4\">
            <div class=\"card h-100\">
              <div class=\"card-body\">
                <h4 class=\"card-title\">
                  <a href=\"#\">$name:$port</a>
                </h4>
                <div class=\"dropdown\">
  <button class=\"btn btn-warning dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Actions
  </button>
  <script>
  function requestServer(){
      $.ajax({
          url: './authPayment.php',
          method: 'POST',
          data: {
              host: $name,
              port: $port,
              password: $password
          }
      })
  }
</script>
  <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
    <a class=\"dropdown-item btn btn-danger\" href=\"./delete.php?id=$id&type=server\">Delete</a>
    <a class=\"dropdown-item\" href=\"./edit.php?id=$id&type=server\">Edit</a>
    <a class='dropdown-item' onclick=''></a>
  </div>
</div>
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

</div>

<footer class="py-5 bg-dark" style="background-color: #181a1b!important;">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; <?php echo $shop_name; ?> 2020</p>
    </div>
</footer>


</body>


