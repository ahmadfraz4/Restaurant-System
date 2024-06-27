<?php
include '../config/config.php';
include '../lib/App.php';


session_start();

if(!isset($_SESSION['user_id'])){
    // die();
    $full_path = (explode('/php/api', $path)[0]);
    
    header("location: $full_path/auth/login.php");
}


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $time = strtotime($_POST['time']);
    $people = $_POST['people'];
    $request = $_POST['request'];
    $paid = false;
    $user_id = $_SESSION['user_id'];
    // $time = strtotime($time);
   
    echo $time;

    // Check if the conversion was successful
 
    if($time > strtotime(date('Y-m-d'))){
        $db = new App;
        $db->insertData("booking",["customer_id"=>$user_id,"name"=>$name,"email"=>$email,"time" => date('Y-m-d H:i:s', $time), "people"=>$people,"request"=>$request], $path);
        // echo $time;
    }else{
        echo 'invalid date';
    }
    


}

?>