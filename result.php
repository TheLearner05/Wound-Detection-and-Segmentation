<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST"){

  include "partials\db_connect.php";

  $hospitalID = $_POST["hospital_id"];
  $kk = file_get_contents('./output.txt',true);
  $kk = rtrim($kk," ");
  $cntInfo = explode(" ",$kk);
  $cntArea = array(); 
  $finalCntArea = array(); 
  //print_r($cntInfo);
  for ($i=0;$i <count($cntInfo);$i++){
      
      
      array_push($cntArea,explode(":",$cntInfo[$i])[1]);

    }
                
  $sql = "INSERT INTO `wound_details` (`hospital_id`,`wound_areas`,`date`) 
            values ( '$hospitalID','$cntArea', current_timestamp())";
            $result = mysqli_query($conn,$sql);

 


}



?>






<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>

  <body>
    <h1>Hello, world!</h1>
    
    <div>
      <P>its here</p>
      
      
      
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>