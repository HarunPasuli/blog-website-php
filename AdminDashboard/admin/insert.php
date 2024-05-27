<?php
    session_start();

    if(!isset($_SESSION['Email']) || $_SESSION['Role'] == 0 ) {
        header("location: ../../PHP/login.php");
        exit();
    }
    else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <title>Document</title>
    <link rel = "stylesheet" href = "CSS/form.css">    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
    <script src = "../../js/form.js"></script>
</head>
<body>
<form method="POST" action="insert.php" id="upload-form" enctype="multipart/form-data">
<h1 style = "text-align: center;">Insert Product</h1>
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
        <b>Allowed types (png, jpeg and jpg). Max file size 8MB.</b>
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
            <option value = 'News'>News</option>
        </select>
    </div>
    <div class="form-group">
        <label for="file-description">File Description:</label>
        <textarea class="form-control" name='content' cols='30' rows='15' id="file-description" wrap="soft"></textarea>
    </div>
    <div class="form-group">
        <label for="file-profile-picture">Profile Picture:</label>
        <div class="file-upload">
            <input type="file" name="fileProfilePicture" id="file-profile-picture" onchange="getFileData2()">
            <span class="file-upload-text">Drag and drop or click to select file</span>
        </div>
        <div class="profile-picture-preview my-element" id="file-upload-preview"></div>
        <b>Allowed types (png, jpeg and jpg). Max file size 8MB.</b>
    </div>
    <div class="form-group">
        <label for="full-name">Full Name:</label>
        <input type="text" class="form-control" name="filePersonalName" id="full-name">
    </div>
    <div class="form-group">
    <button type="submit" name="upload" class="insert-btn">Insert</button>
        <button type="reset" name="cancel" class="cancel-btn">Cancel</button>
    </div>
</form>


    <?php
include("connect.php");
ini_set('display_errors', 0);
$max_size = 20 * 1024 * 1024; // 8 MB in bytes
$allowed_types = array('jpg', 'jpeg', 'png');
$file_size = $_FILES['fileUpload']['size'];
$file_size2 = $_FILES['fileProfilePicture']['size'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($file_size > $max_size || $file_size2 > $max_size) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'File size cannot be bigger than 8mb!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
            window.open('insert.php','_self');
        });
        </script>";
        exit();
    }

    $file_ext = strtolower(pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION));
    $file_ext2 = strtolower(pathinfo($_FILES['fileProfilePicture']['name'], PATHINFO_EXTENSION));
    if (!in_array(strtolower($file_ext), $allowed_types) || !in_array(strtolower($file_ext2), $allowed_types)) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'File type not allowed!',
          footer: 'Allowed file types are JPEG,JPG and PNG',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
            window.open('insert.php','_self');
        });
        </script>";
        exit();
    }
    
    if (isset($_POST['upload'])) {
        $email = $_SESSION['Email'];
        $fileName = mysqli_real_escape_string($connect, $_POST['fileName']);
        $fileDescription = mysqli_real_escape_string($connect, $_POST['content']);
        $fileUpload = $_FILES['fileUpload']['name'];
        $fileUpload_temp = $_FILES['fileUpload']['tmp_name'];
        $fileProfilePicture = $_FILES['fileProfilePicture']['name'];
        $fileProfilePicture_temp = $_FILES['fileProfilePicture']['tmp_name'];
        $filePersonalName = mysqli_real_escape_string($connect, $_POST['filePersonalName']);
        $fileCategories = mysqli_real_escape_string($connect, $_POST['fileCategories']);
        date_default_timezone_set('Europe/Tirane');
        // $productDate = date("F j, Y, g:i a", time());

        if ($fileName == '' || $fileUpload == '' || $fileProfilePicture == '' || $filePersonalName == '' || $fileDescription == '') {
            echo "<script>
            Swal.fire({
              title: 'Error!',
              text: 'Any input is empty!',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then((result) => {
                return false;
            });
            </script>";
            exit();
        } else {
            $insert = "SELECT * FROM products WHERE fileName = '$fileName' OR fileUpload = '$fileUpload' LIMIT 1";
            $query = mysqli_query($connect,$insert);
            $exist = mysqli_fetch_assoc($query);

            if ($exist) {
                if (strtolower($exist['fileName']) === strtolower($fileName)) {
                    echo "<script>
                    Swal.fire({
                      title: 'Error!',
                      text: 'This file already exists!',
                      icon: 'error',
                      confirmButtonText: 'OK'
                    }).then((result) => {
                        return false;
                    });
                    </script>";
                    exit();
                }
            } else {
                $uploadPath = "file/";
                $uploadFile = $uploadPath . basename($fileUpload);
                $uploadProfilePicture = $uploadPath . basename($fileProfilePicture);

                $uploadFileError = $_FILES["fileUpload"]["error"];
                $uploadProfilePictureError = $_FILES["fileProfilePicture"]["error"];

                if (($uploadFileError == 0) && ($uploadProfilePictureError == 0)) {
                    if(move_uploaded_file($fileUpload_temp, $uploadFile) && move_uploaded_file($fileProfilePicture_temp, $uploadProfilePicture)) {
                        $uploadFile = "INSERT INTO products(fileName,fileUpload,fileDescription,fileProfilePicture,filePersonalName,fileCategories,Email) VALUES('$fileName','$fileUpload','$fileDescription','$fileProfilePicture','$filePersonalName','$fileCategories','$email');";
                        if (mysqli_query($connect,$uploadFile)) {
                            echo "<script>
                            Swal.fire({
                            title: 'Success!',
                            text: 'File has been submitted!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            window.open('../../html/index.php','_self');
                            });
                            </script>";
                            exit();
                        } else {
                            echo "<script>
                            Swal.fire({
                              title: 'Error!',
                              text: 'Upload failed!',
                              icon: 'error',
                              confirmButtonText: 'OK'
                            }).then((result) => {
                                return false;
                            });
                            </script>";
                            exit();
                        }
                    } else {
                        echo "<script>
                        Swal.fire({
                          title: 'Error!',
                          text: 'There was an error uploading your file!',
                          icon: 'error',
                          confirmButtonText: 'OK'
                        }).then((result) => {
                            return false;
                        });
                        </script>";
                        exit();
                    }
                } else {
                    echo "<script>
                    Swal.fire({
                      title: 'Error!',
                      text: 'There was an error uploading your file!',
                      icon: 'error',
                      confirmButtonText: 'OK'
                    }).then((result) => {
                        return false;
                    });
                    </script>";
                    exit();
                }
            }
        }
    }
}
}
?>
</body>
</html>