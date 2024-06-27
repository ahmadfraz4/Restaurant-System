<?php
// define method is to define a constant who's can't  change
define("HOST", "localhost");
define("DB_NAME", "restoran");
define("USER", "root");
define("PASS", "");
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$host_name = $_SERVER['HTTP_HOST'];

$full_path = 'http://'.$host_name.$basePath;
$path = "http://localhost/PHP/projects/Restaurant-System-main";



// echo $path;
// die();


?>