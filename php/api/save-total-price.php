<?php
include '../config/config.php';


// Get the raw POST data
$postData = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($postData, true);


if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if ($data !== null && isset($data['total_price'])) {
    $total_price = $data['total_price'];
    $_SESSION['total_price'] = $total_price;
    $_SESSION['ordered_food'] = $data['ordered_items'];
   
    echo json_encode(['success'=>true, 'path'=>"$path/food/checkout.php"]);
} else {
    // echo "Total price not received from the POST request.";
    echo json_encode(['success'=>false, 'path'=>""]);
}

// header("location: $path/checkout.php");



?>