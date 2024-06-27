<?php include "../public/global/header.php";
include '../config/config.php';
include '../lib/App.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$db = new App;
$user_id = $_SESSION['user_id']; 
$data = $db->selectData("booking",['customer_id'=>$user_id]);
 



if(!isset($_SESSION['user_id'])){
  header("location: ".APP_URL.'/auth/login.php');
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
      <?php include "../public/global/navbar.php" ?>

      <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
          <h1 class="display-3 text-white mb-3 animated slideInDown">Bookings</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Bookings</a></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- Navbar & Hero End -->


    <!-- Service Start -->
    <div class="container">

      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">No. of People</th>
              <th scope="col">Time</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php
                if(count($data) > 0){
                    foreach($data as $book){
            ?>
            <tr>
              <th><?php echo $book['name'] ?></th>
              <th><?php echo $book['email'] ?></th>
              <td><?php echo $book['people'] ?></td>
              <td><?php echo $book['time'] ?></td>
              <td><?php echo $book['status'] ?></td>
            </tr>
            <?php }} ?>            
          </tbody>
        </table>
        <div class="position-relative mx-auto" style="max-width: 400px; padding-left: 679px;">
          
            <button type="button" id="submit_button" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">Checkout</button>
          
        </div>
      </div>
    </div>
    <!-- Service End -->


    <!-- Footer Start -->
    <?php include "../public/global/footer.php" ?>
</body>