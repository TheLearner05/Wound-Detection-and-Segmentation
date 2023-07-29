<?php
$showAlert = false;
session_start();
$output=array();
$isImg = false;
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
  }   




$fileName="";

//if (isset($_POST['submit'])){
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
        $showAlert = true;
    }
    else{
        $file = $_FILES['image'];
        $fileName = $file['name'];
               
        $fileTmpPath = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $filetype = $file['type'];

        $fileExt = explode(".",$fileName);

        $fileExt = strtolower($fileExt[1]);
        $allowedExt = array('jpg','jpeg','png','pdf');


        if(in_array($fileExt,$allowedExt)){
            if ($fileError === 0){
                if ($fileSize <1000000){
                    $fileNameNew = date('Y-m-d_H-i-s') .".".$fileExt;
                    $filePath = "C:/a/xampp/htdocs/webApp/uploads/".$fileNameNew;
                    move_uploaded_file($fileTmpPath,$filePath);
                    

                    $command = escapeshellcmd("python C:/a/xampp/htdocs/webApp/app2.py" . " ".$filePath);

                    shell_exec($command );

                    $isImg = true;

                }
                
                else
                {
                    echo " your file is too big";
                }

            }
            else
            {
                echo 'file is not uploaded properly';
            }


        }
        else
        {
            echo 'invalid extension';
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
    <link rel="stylesheet" href='upload.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>
    Welcome - <?php echo $_SESSION['hospital ID'];?>
    <h1 style="color: aliceblue;font-size: 5vw;">Welcome to CMC Wound Detection App</h1>
    <h2>Please upload your wound image here</h2>
    <?php
      if($showAlert){
        echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Please select the image.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        
        
      }
     
    ?>

    <div class="container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">

            <div class="inputField">  
                <input type = "file" name='image'  id = "imageInput">
            </div>
           
            <div class="button">
                <input class="btn btn-secondary" type = "submit" name='submit' value="Upload">
            </div>
            <div class="button">
                
                <a href="login.php" class="btn btn-secondary">LogOut</a>
            </div>
            

        </form>
    </div>
    <div >
        
        
        <?php
        if ($isImg == true){
            echo'<P>hello. This is your segmented wounds</p>';
            echo'<div class="img"> <img src="output_segs.jpg" alt="Segmented wound"/></div>';
            
            include "partials/db_connect.php";
            $kk = file_get_contents('./output.txt',true);
            $kk = rtrim($kk," ");
            $cntInfo = explode(" ",$kk);
            $cntArea = array(); 
            $finalCntArea = array(); 
            $hi = $_SESSION['hospital ID'];
            //print_r($cntInfo);
            for ($i=0;$i <count($cntInfo);$i++){
                array_push($cntArea,explode(":",$cntInfo[$i])[1]);
                }
            $cntArea = implode(" ",$cntArea);             
            $sql = "INSERT INTO `wound_details` (`hospital_id`,`wound_areas`,`date`) 
                        values ( '$hi','$cntArea', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            
        }

        ?>

       
        

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>