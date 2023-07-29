<?php
$showAlert = false;
$showError = false;
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    include "partials\db_connect.php";

    $username = $_POST['pname'];
    $hospitalID = $_POST['hospitalID'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    
    //check if user exists.

    $existSql = "SELECT * FROM user_details WHERE hospital_id = '$hospitalID'";
    $result = mysqli_query($conn,$existSql);
    $numRows = mysqli_num_rows($result);

    if ($numRows > 0){
        if($username = "" || $hospitalID="" || $password="" || $cpassword=""){
            $showError = "Please fill all the fields";
        }else{$showError = "User already Exists";}

        
    }

    else{
        if ($password == $cpassword){
            $sql = "INSERT INTO `user_details` (`patient_name`,`hospital_id`,`password`,`date`) 
            values ('$username', '$hospitalID','$password', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                $showAlert = true;



            }
        }else{$showError="passswords are not matching";}
    }



}


?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebApp</title>        
    <link rel="stylesheet" href='./signup.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    

</head>
<body>
    <?php
      if($showAlert){
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are account is created.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        header("Location: login.php");
        exit(); // Terminate the current script
      }
      if($showError){
        echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> '.$showError.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
      } 
    ?>




    <h1 style="color: aliceblue;font-size: 5vw;">Welcome to CMC Wound Detection App</h1>
    <h2>Sign up Page</h2>
  
    <div class="container">
        <form action="signup.php" method="POST">
            <div class="inputField">
                <label class = 'label' for="Name of Patient">Name of Patient :</label>
                <input type = "PName" name="pname" required>
            </div>
            <div class="inputField">
                <label class = 'label' for="age">HospitalId No. :</label>
                <input type = "username" name='hospitalID' required>
            </div>
            <div class="inputField">
                <label class = 'label' for="password">Please enter your Password :</label>
                <input type = "password" name="password" required>
            </div>

            <div class="inputField">
                <label class = 'label' for="cpassword">Please Confirm your Password :</label>
                <input type = "password" name="cpassword" required>
            </div>

            <div class="submit">
                <input type = "submit" value="Submit">
            </div>
            
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>