<?php 



include "../php/public/global/header.php";
include "../php/config/config.php";
include "../php/lib/App.php";

session_start();

if(!isset($_SESSION['admin'])){
    if($_SESSION['admin'] != 1){
        header("location: ".APP_URL);
        exit();
    }
}

if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $image = $_FILES['image'];
  $price = $_POST['price'];
  $description = $_POST['description'];


  $db = new App;

  $db->insertData("food", ["name" => $name, "price" => $price,"description" => $description ,"image" => $image], APP_URL);

}  
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
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Add Food</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Add-Food</a></li>
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
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Login</h5>
                        <h1 class="text-white mb-4">Login</h1>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="col-md-12" enctype="multipart/form-data">
                            <div class="row g-3">
                               
                                <div class="">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                                        <label for="name">Name</label>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="form-floating">
                                        <input name="description" type="text" class="form-control" id="description" placeholder="Description">
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-floating">
                                        <input name="price" type="number" class="form-control" id="price" placeholder="Price">
                                        <label for="price">Price</label>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="form-floating">
                                        <input name="image" type="file" class="form-control" id="image" accept="image/*">
                                        <label for="image">Image</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button name="submit" class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- Service End -->
        

        <!-- Footer Start -->
        <?php include "../php/public/global/footer.php" ?>    
</body>

</html>