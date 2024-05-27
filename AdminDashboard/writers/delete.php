<?php

include('connect.php');

if(isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    $delete_query = "DELETE FROM products WHERE PID = '$delete_id'";
    
    if(mysqli_query($connect, $delete_query)) {

        echo "<script> alert('The product has been deleted!') </script>";

        echo "<script> window.open('view.php','_self');</script>";
    }
}

?>