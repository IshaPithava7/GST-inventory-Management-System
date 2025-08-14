<?php

$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "db_gst_inventory_management_system";

// CREATE CONNECTION
$connect = mysqli_connect($server_name, $user_name, $password, $db_name);

// CHECK CONNECTION
if(!$connect){
    die("Connection Failed: " . mysqli_connect_error());
}

// echo "Database Connected Successfully";

?>