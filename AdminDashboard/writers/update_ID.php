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
        echo "<script> alert(\"You can't upload this image!\") </script>"; // if file folder doesn't exist
    }

    if($fileName1 == '' || $fileDescription1 == '' || $fileUpload1 == '' || $fileCategories1 == '')  {
        echo "<script> alert('One of the fields is empty!') </script>";
        echo "<script> console.log('Empty fields:',";
        if ($fileName1 == '') { echo "'fileName' "; }
        if ($fileDescription1 == '') { echo "'fileDescription' "; }
        if ($fileUpload1 == '') { echo "'fileUpload' "; }
        if ($fileCategories1 == '') { echo "'fileCategories' "; }
        echo "); </script>";
        echo "<script> window.open('view.php','_self');  </script>";
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
            echo "<script> alert('File is updated!'); </script>";
            echo "<script> window.open('view.php','_self'); </script>";
            // header("location: viewFile(Update&Delete).php");
        }
    }
} 
?>
