<?php
$connect = mysqli_connect("localhost", "root", "", "website_blog_hp");
mysqli_select_db($connect, "website_blog_hp");

if (isset($_POST['delete']) && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $delete_query = "DELETE FROM userproducts WHERE PID = '$post_id'";

    if (mysqli_query($connect, $delete_query)) {
        echo "Post has been deleted.";
    } else {
        echo "Error deleting post: " . mysqli_error($connect);
    }
}

exit();
?>
