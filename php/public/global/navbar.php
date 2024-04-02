<?php

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
    <a href="" class="navbar-brand p-0">
        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1>
        <!-- <img src="img/logo.png" alt="Logo"> -->
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="<?php echo APP_URL; ?>/index.php" class="nav-item nav-link active">Home</a>
            <a href="<?php echo APP_URL; ?>/about.php" class="nav-item nav-link">About</a>
            <a href="<?php echo APP_URL; ?>/service.php" class="nav-item nav-link">Service</a>
            <a href="<?php echo APP_URL; ?>/menu.php" class="nav-item nav-link">Menu</a>
            <a href="<?php echo APP_URL; ?>/cart.php" class="nav-item nav-link"><i class="fa-sharp fa-solid fa-cart-shopping"></i>Cart</a>


            <a href="<?php echo APP_URL; ?>/contact.php" class="nav-item nav-link">Contact</a>
             <?php
             if (session_status() === PHP_SESSION_NONE) {
                session_start(); // Start the session
             }
              if(!isset($_SESSION['user_id'])){
             ?>
                <a href="<?php echo APP_URL; ?>/auth/login.php" class="nav-item nav-link">Login</a>
                <a href="<?php echo APP_URL; ?>/auth/register.php" class="nav-item nav-link">Register</a>
            <?php  }else{ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php echo $_SESSION['email'] ?>
                    </a>
                    <ul class="dropdown-menu" style="top: 60px; right: 0; ">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/php/api/booked.php">Bookings</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/php/api/orders.php">Orders</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/auth/logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php } ?>


        </div>

    </div>
</nav>