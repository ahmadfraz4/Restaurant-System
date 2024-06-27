<?php
include '../config/config.php';
include '../lib/App.php';
session_start();
$db = new App;
$price =  $_SESSION['total_price'];
$ordered_food =  serialize($_SESSION['ordered_food']);
$user_id = $_SESSION['user_id'];
  $order_email =  $_SESSION['order_email'] ;
  $order_phone =   $_SESSION['order_phone'] ;
  $order_name =   $_SESSION['order_name'] ;
  $order_address =   $_SESSION['order_address'] ;

 $db->insertData("orders",["customer_id"=> $user_id,"ordered_food"=>$ordered_food,
    "phone"=>$order_phone,"name"=>$order_name,"address"=>$order_address, "email"=> $order_email, "price" => $price]);


?>
<body>
    <?php
        echo '<script>';
        echo "localStorage.removeItem('cart');";
        echo "window.location.href='$path'";
        
        echo "</script>";
    
    ?>
</body>