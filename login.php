<?php
$login = false;
$showError = false;
$hospitalID="";
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    include "partials\db_connect.php";
    
    $hospitalID = $_POST["hospital_id"];          
    $password = $_POST['password'];
    if ($hospitalID == "" || $password == ""){
        echo'<div class="alert alert-Danger alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Please fill all the fields
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    else{
    $sql = "SELECT * FROM user_details WHERE hospital_id = '$hospitalID' AND password ='$password'";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows==1){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['hospital ID'] = $hospitalID;
        header('location:upload.php'); 
    }
    else{
        $showError = "Invalid Credentials";
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebApp</title>        
    <link rel="stylesheet" href='login.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>

    <?php
      if($login){
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
      }
      if($showError){
        echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> '.$showError.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
      } 
    ?>
    <h1 style="color: aliceblue;font-size: 5vw;">Welcome to CMC Wound Detection App</h1>
    <h2>Login Page</h2>

    <div class="container">
        <form action="login.php" method="POST" >

            <div class="inputField">
                <label class = 'label' for="age">Hospital Id No. :</label>
                <input type = "username" name="hospital_id">
            </div>
            <div class="inputField">
                <label class = 'label' for="password">Please enter your Password :</label>
                <input type = "password" name="password">
            </div>
            <div class="button">
                <input type = "submit" value="Submit" class="btn btn-secondary">
            </div>
            <div class="button">  
                <a href="signup.php" class="btn btn-secondary">Go back to Signup</a>
            </div>
            
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
