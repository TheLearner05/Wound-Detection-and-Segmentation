<?php

$server = "";
$username  = "";
$password  = "";
$database ="" ;
$port = "";

$conn = mysqli_connect($server,$username, $password, $database,$port);

if (!$conn){
   

    die("error". mysqli_connect_error());
}


?>