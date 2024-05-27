<?php
include('connect.php');

if (isset($_POST['delete']) && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $delete_query = "DELETE FROM products WHERE PID = '$post_id'";

    if (mysqli_query($connect, $delete_query)) {
        echo "Post has been deleted.";
    } else {
        echo "Error deleting post: " . mysqli_error($connect);
    }
}

exit();
?>
