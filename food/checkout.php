<?php include "../php/public/global/header.php"; 
include "../php/config/config.php";
include "../php/lib/App.php";
?>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
        <?php include "../php/public/global/navbar.php" ?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Checkout</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Checkout</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Service Start -->
            <div class="container">
                
                <div class="col-md-12 bg-dark">
                    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservation</h5>
                        <h1 class="text-white mb-4">Checkout</h1>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="col-md-12">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" value="<?php echo $_SESSION['email'] ?>" name="email" id="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" readonly value="<?php echo $_SESSION['total_price'] ?>" disabled class="form-control" id="price" placeholder="Your Email">
                                        <label for="price">Price</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="tel"  class="form-control" name="phone" id="phone" placeholder="Phone number">
                                        <label for="text">Phone number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Address" name="address" id="message" style="height: 100px"></textarea>
                                        <label for="message">Address</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" name="submit" type="submit">Order and Pay Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        <!-- Service End -->
        

        <!-- Footer Start -->
        <?php include "../php/public/global/footer.php" ?>
</body>
<?php



if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$db = new App;

// $data = $db->selectData("orders",["id"=>2]);
// print_r(unserialize($data[0]['ordered_food']));


if(!isset($_SESSION['user_id'])){
    header("location: ".APP_URL.'/auth/login.php');
}

$price =  $_SESSION['total_price'];
$ordered_food =  serialize($_SESSION['ordered_food']);
$user_id = $_SESSION['user_id'];


if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $address = $_POST['address'];

    // $db->insertData("orders",["customer_id"=> $user_id,"ordered_food"=>$ordered_food,
    // "phone"=>$phone,"name"=>$name,"address"=>$address, "email"=> $email, "price" => $price]);

    echo "<script>";
    echo "window.location.href='../php/payment/pay.php'";
    // echo "localStorage.removeItem('cart');";
    echo "</script>";
    // header("location: ". APP_URL. "/php/payment/pay.php");

}


?>
</html>