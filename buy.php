<?php
session_start();
include "auth.php";
include "./utils/DatabaseManager.php";
if(!isset($_GET["pid"])){
    header("Location: $base");
}
$db = new DatabaseManager($con_settings);
$id = $_GET["pid"];
$res = $db->query("SELECT * FROM products WHERE id=?", "i", [$id]);
if(count($res[0]) === 0){
    header("Location: $base");
}
$image = $res[0]["image"];
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
        <div class="card" style="">
            <img class="card-img-top" src=".<?php echo $image; ?>" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Buy <?php echo $res[0]["name"];?></h5>
                <b>&dollar;<?php echo $res[0]["price"]?></b>
                <p class="card-text"><?php echo $res[0]["description"];?></p>
                <div id="paypal-button"></div>
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

<script>
    function activateLoadingScreen(){
        $("#body").addClass("fade-out");
        setTimeout(function(){
            document.getElementById("load").innerHTML = `<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  Processing your Payment...
</button>`;
        },1000)
    }

    function desactivateLoaderScreen(){
        document.getElementById("load").innerHTML = ``;
        $("#body").addClass("fade-in");
    }
    paypal.Buttons({
        createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $res[0]["price"]; ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            activateLoadingScreen();
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function (details) {
                details.link = details.links[0].href;
                details.product_id = '<?php echo $id;?>';
                details.price = '<?php echo $res[0]["price"];?>';
                // This function shows a transaction success message to your buyer.
                $.ajax({
                    url: "./utils/PayPal/authPayment.php",
                    method: "POST",
                    data: details,
                    success: function (data) {
                        desactivateLoaderScreen();
                        setTimeout(function(){
                            let json = JSON.parse(data);
                            let type = json.error === true ? "error" : "success";
                            let title = json.error === true ? "Error" : "Success!";
                            console.log( typeof json);
                            Swal.fire({
                                icon: type,
                                title: title,
                                text: json.m
                            }).then(d => {
                                if(json.error){
                                    window.location.href = "./error.php?pid=<?php echo $id?>&user=<?php echo $_SESSION["username"];?>";
                                } else {
                                    window.location.href = "./success.php?pid=<?php echo $id?>&user=<?php echo $_SESSION["username"];?>";
                                }
                            })
                        }, 1000);
                        // alert(JSON.stringify(data));
                    },
                });
                console.log(details);
            });
        }
    }).render('#paypal-button');
    //This function displays Smart Payment Buttons on your web page.
</script>

</body>

</html>