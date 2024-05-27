<?php
    include("../connect.php");
    ini_set('display_errors', 0);
    if (isset($_POST['upload'])) {
        $email = $_SESSION['Email'];
        $fileId = $_POST['fileId'];
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
                window.open('approve.php','_self');
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
                        window.open('approve.php','_self');
                    });
                    </script>";
                    exit();
                }
            } else {
                $uploadPath = "../file/";
                $uploadFile = $uploadPath . basename($fileUpload);
                $uploadProfilePicture = $uploadPath . basename($fileProfilePicture);

                $uploadFileError = $_FILES["fileUpload"]["error"];
                $uploadProfilePictureError = $_FILES["fileProfilePicture"]["error"];

                if (($uploadFileError == 0) && ($uploadProfilePictureError == 0)) {
                    if(move_uploaded_file($fileUpload_temp, $uploadFile) && move_uploaded_file($fileProfilePicture_temp, $uploadProfilePicture)) {
                        $uploadFile = "INSERT IGNORE INTO products(fileName,fileUpload,fileDescription,fileProfilePicture,filePersonalName,fileCategories,Email) VALUES('$fileName','$fileUpload','$fileDescription','$fileProfilePicture','$filePersonalName','$fileCategories','$email');";
                        if (mysqli_query($connect,$uploadFile)) {
                            $delete_query = "DELETE FROM userproducts WHERE PID = '$fileId'";
                            mysqli_query($connect, $delete_query); // Deleting the product
                            echo "<script>
                            Swal.fire({
                              title: 'Success!',
                              text: 'File has been successfully uploaded!',
                              icon: 'success',
                              confirmButtonText: 'OK'
                            }).then((result) => {
                                window.open('approve.php','_self');
                            });
                            </script>";
                        } else {
                            echo "<script>
                            Swal.fire({
                              title: 'Error!',
                              text: 'Upload failed!',
                              icon: 'error',
                              confirmButtonText: 'OK'
                            }).then((result) => {
                                window.open('approve.php','_self');
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
                            window.open('approve.php','_self');
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
                        window.open('approve.php','_self');
                    });
                    </script>";
                    exit();
                }
            }
        }
    }
?>