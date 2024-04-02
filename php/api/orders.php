<?php include "../public/global/header.php";
include '../config/config.php';
include '../lib/App.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$db = new App;
$user_id = $_SESSION['user_id']; 
$data = $db->selectData("orders",['customer_id'=>$user_id]);




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
    <div class="col-11 mx-auto" >

      <div style="overflow-x: auto;">
        <table id="order-table" class="table">
          <thead>
            <tr>
              <th class="order-th">Name</th>
              <th class="order-th">Email</th>
              <th class="order-th">Phone no.</th>
              <th class="order-th">Order</th>
              <th class="order-th">Address</th>
              <th class="order-th">Payment</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php
                if(count($data) > 0){
                    foreach($data as $order){
                        $foods = unserialize($order['ordered_food']);
            ?>
            <tr >
              <td class="order-td" ><?php echo $order['name'] ?></td>
              <td class="order-td"><?php echo $order['email'] ?></td>
              <td class="order-td"><?php echo $order['phone'] ?></td>
              <td class="" >
              <?php 
                    foreach($foods as $food){
                        $food_data = $db->selectData("food",["id"=>$food]);
                        foreach($food_data as $food_name){
                            echo '-'.$food_name['name'].'<br>';
                        }
                    }
                        
              ?>
              </td>
              <td  ><?php echo $order['address'] ?></td>
              <td class="order-td"><?php echo $order['paid'] == true ? 'paid': 'pending' ?></td>
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