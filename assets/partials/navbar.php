<style>
    .dropdown-menu {
        background-color: rgb(24, 26, 27);
        border-top-color: rgba(102, 102, 102, 0.15);
        border-right-color: rgba(102, 102, 102, 0.15);
        border-bottom-color: rgba(102, 102, 102, 0.15);
        border-left-color: rgba(102, 102, 102, 0.15);
    }
    .dropdown-item {
        color: rgb(218, 215, 210);
    }
    .dropdown-item:hover {
        color: rgb(223, 220, 216);
        text-decoration-color: initial;
        background-color: rgb(26, 28, 29);
    }
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }
</style>
<script>
    $(document).ready(function(){
        $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="background-color: #181a1b!important;">
    <div class="container">
      <a class="navbar-brand" href="<?php echo $base;?>"><?php echo $shop_name; ?> | Logged in as <?php echo $_SESSION["username"]; ?></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-link" href="<?php echo $base; ?>">Home</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="<?php echo $base . "logout.php"; ?>">Logout</a>
        </li>
        <?php
        if(isset($_SESSION["user"]) && isset($_SESSION["password"])){
            $logout = $base . "dashboard/logout.php";
            $dashboard = $base . "dashboard";
            $add = $dashboard . "/add.php";
            $purchases = $dashboard . "/purchases.php";
            echo "
                    <li class=\"nav-item dropdown \">
            <a class=\"nav-link dropdown-toggle\" style=\"color: white\" href=\"\" id=\"navbarDropdownMenuLink\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                Dashboard
            </a>
            <ul class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownMenuLink\">
                <li  ><a href=\"$dashboard\" class=\"dropdown-item\">Home</a></li>
                <li ><a href=\"$logout\" class=\"dropdown-item\" >Logout</a></li>
                <li ><a href=\"$purchases\" class=\"dropdown-item\" >Purchases</a></li>
                <li class=\"nav-item dropdown-submenu\">
                    <a class=\"test dropdown-item dropdown-toggle\" tabindex=\"-1\" href=\"\" style=\"background-color: rgb(24, 26, 27); color: white\">Create<span class=\"caret\"></span></a>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" tabindex=\"-1\" href='" . $add . "?type=product"."'>Product</a></li>
                        <li><a class=\"dropdown-item\" tabindex=\"-1\" href='" . $add . "?type=user"."'>User</a></li>
                        <li><a class=\"dropdown-item\" tabindex=\"-1\" href='" . $add . "?type=category"."'>Category</a></li>
                        <li><a class=\"dropdown-item\" tabindex=\"-1\" href='" . $add . "?type=server"."'>Server</a></li>
                    </ul>
                </li>
            </ul>
        </li>";
        } else {
            $login = $base . "dashboard/login.php";
            echo "
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"$login\">Admin Login</a>
        </li>
            ";
        }
        ?>
    </ul>
</div>
</div>
</nav>