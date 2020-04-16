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

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

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
<footer class="py-5 bg-dark" style="background-color: #181a1b!important;">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; <?php echo $shop_name; ?> 2020</p>
    </div>
    <!-- /.container -->
</footer>
<script>
    paypal.Button.render({
        // Configure environment
        env:  <?php echo ($sandbox === true) ? "'sandbox'" : "'production'"; ?>,
        client: {
            sandbox: <?php echo "'$paypal_app_client_id_sandbox'"; ?>,
            production:  <?php echo "'$paypal_app_client_id'"; ?>
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'responsive',
            color: 'black',
            shape: 'rect',
            label: 'checkout'
        },
        // Enable Pay Now checkout flow (optional)
        commit: true,
        // Set up a payment
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: '<?php echo $res[0]["price"]; ?>',
                        currency: 'USD'
                    }
                }]
            });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                $.ajax({
                    url: "./utils/PayPal/authPayment.php",
                    method: "POST",
                    data: data,
                    success: function(data){alert(JSON.stringify(data));},
                    error: function(errMsg) {
                        alert(JSON.stringify(errMsg));
                    }
                });                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
        }
    }, '#paypal-button');

</script>

</body>

</html>