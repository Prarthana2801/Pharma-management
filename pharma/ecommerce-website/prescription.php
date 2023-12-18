

<?php


include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;
include 'components/connect.php';
$con = new mysqli("localhost","root","","pharma");
$sql="SELECT * FROM `prescription`";
$result=mysqli_query($con,$sql);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["anyfile"]) && isset($_POST['submit'])){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["anyfile"]["name"];
        $filetype = $_FILES["anyfile"]["type"];
        $filesize = $_FILES["anyfile"]["size"];
    
        // Validate file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
     
        // Validate file size - 10MB maximum
        $maxsize = 10 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
     
        // Validate type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
           
                if(move_uploaded_file($_FILES["anyfile"]["tmp_name"], "admin\prisc\\" . $filename)){
 
                    $sql2="INSERT INTO `prescription`(`name`, `type`, `size`) VALUES ('$filename','$filetype','$filesize')";
                    mysqli_query($con,$sql2);
 
                    echo "<script>alert('upload success');</script>";

                }else{
 
                   echo "File is not uploaded";
                }
                 
            } 
         else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo "Error: " . $_FILES["anyfile"]["error"];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>prescription</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
<?php include 'components/user_header.php'; ?>

    <div style="margin-left:10px;margin-top:0px;">
    <h3 style="font-size: 35px;color:black;">PAYBACK TIME: PHARMA WORLDWIDE</h3><br><br>

    <h2>The customers are given the priviledge to upload their medical prescription and fetch their medical services/requirements comfortably.</h2><br>

    
    <div style="margin-left:0px;">  
        <form action=" " method="post" enctype="multipart/form-data" style="margin-left:180px;font-size:20px;">
        <!-- <h2><img src="icons\icons8-image-file-64.png" style="vertical-align:middle">Upload Alumni Image :</h2> -->
        <h4 style="color:green;">Please upload a screenshot of your approved medical prescription</h4>

        <input type="file" name="anyfile" id="anyfile">
        <!-- <input type="submit" name="submit" value="Upload" onclick="alert('Submitted Successfully');"> -->
        <button style="border:2px solid black;background-color:black;cursor:pointer;color:white;width:100px;border-radius:4px;margin-left:0px;margin-top:30px;padding:10px;" name="submit"><b style="font-size:20px;">Upload</b></button>
        <p style="color:red;"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
    </form></div><br><br><br><br><br><br>
    <?php include 'components/footer.php'; ?>
</body>
</html>
