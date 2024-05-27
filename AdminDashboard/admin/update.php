<?php
    session_start();

    if(!isset($_SESSION['Email']) || $_SESSION['Role'] == 0 || $_SESSION['Role'] != 1) {
        header("location: ../../PHP/login.php");
        exit();
    }
    else {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <title>Update Blog</title>
       <link rel = "stylesheet" href = "css/form.css">    
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
    <script src = "../../js/form2.js" defer></script>
</head>

<body>

<?php

$connect = mysqli_connect("localhost", "root", "", "website_blog_hp");
mysqli_select_db($connect, "website_blog_hp");

if(isset($_GET['update'])) {

    $update_id = $_GET['update'];

    $select = "SELECT * FROM products WHERE PID = '$update_id'";

    $query = mysqli_query($connect, $select);

    $row = mysqli_fetch_array($query);

?>

    <div class="container">
        <!-- <h1>Update Product</h1> -->

        <form method='post' action="" id="upload-form" enctype="multipart/form-data">
            <input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
        <h1>Update Product</h1>
    <div class="form-group">
        <label for="file-name">File Name:</label>
        <input type="text" class="form-control" name="fileName" id="file-name">
    </div>
    <div class="form-group">
        <label for="file-upload">File Upload:</label>
        <div class="file-upload">
            <input type="file" name="fileUpload" id="file-upload" onchange="getFileData()">
            <span class="file-upload-text">Drag and drop or click to select file</span>
        </div>
        <div class="file-name-preview my-element" id="file-upload-preview"></div>
    </div>
    <div class="form-group">
        <label for="file-category">File Category:</label>
        <select class="form-control" name='fileCategories' id="file-category">
            <option value='Mobile'>Mobile</option>
            <option value='Tech'>Tech</option>
            <option value='Gaming'>Gaming</option>
            <option value='Design'>Design</option>
            <option value='Anime'>Anime</option>
            <option value='Programming'>Programming</option>
            <option value='Sports'>Sports</option>
        </select>
    </div>
    <div class="form-group">
        <label for="file-description">File Description:</label>
        <textarea class="form-control" name='content' cols='30' rows='15' id="file-description"></textarea>
    </div>
    <div class="form-group">
    <input type="submit" name="update" value="Update" class = "insert-btn">
        <button type="reset" name="cancel" class="cancel-btn">Cancel</button>
    </div>
    </div>
    <?php
include('connect.php');
error_reporting();

if(isset($_POST['update'])) {
    $fileId = $_POST['PID'];
    $fileName1 = mysqli_real_escape_string($connect, $_POST['fileName']);
    $fileDescription1 = mysqli_real_escape_string($connect, $_POST['content']);
    $fileUpload1 = $_FILES['fileUpload']['name'];
    $fileUpload1_tmp = $_FILES['fileUpload']['tmp_name'];
    $fileCategories1 = mysqli_real_escape_string($connect, $_POST['fileCategories']);

    if(!move_uploaded_file($fileUpload1_tmp,"file/$fileUpload1")) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'You cannot upload this file!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then(() => {
            window.open('view.php','_self');
        });
        </script>";
        exit();
    }

    if($fileName1 == '' || $fileDescription1 == '' || $fileUpload1 == '' || $fileCategories1 == '')  {
        // echo "<script> alert('One of the fields is empty!') </script>";
        // echo "<script> console.log('Empty fields:',";
        // if ($fileName1 == '') { echo "'fileName' "; }
        // if ($fileDescription1 == '') { echo "'fileDescription' "; }
        // if ($fileUpload1 == '') { echo "'fileUpload' "; }
        // if ($fileCategories1 == '') { echo "'fileCategories' "; }
        // echo "); </script>";
        // echo "<script> window.open('view.php','_self');  </script>";
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'One of the fields is empty!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
            window.open('view.php','_self');
        });
        </script>";
        exit();
    }
    else {
        $update_query = "UPDATE products SET
        fileName = '$fileName1',
        fileUpload = '$fileUpload1',
        fileDescription = '$fileDescription1',
        fileCategories = '$fileCategories1'
        WHERE
        PID = '$fileId'";

        if (mysqli_query($connect, $update_query)) {
            echo "<script>
            Swal.fire({
              title: 'Success!',
              text: 'File is updated!',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then((result) => {
                window.open('view.php','_self');
            });
            </script>";
            exit();
            // header("location: viewFile(Update&Delete).php");
        }
    }
} 
?>

<?php }
}?>
</body>
</html>
