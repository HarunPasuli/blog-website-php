<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src = "../js/edit-comment.js" defer></script>
<?php
session_start(); 
if(!isset($_SESSION['Email'])) {
    echo "<script> window.open('login.php','_self'); </script>";
} 
else {
    include('connect.php');
    $id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];
    $query = "SELECT * FROM comments WHERE id ='$id'";
    $result = mysqli_query($connect, $query);
    $comment = mysqli_fetch_assoc($result);

    if (isset($_POST['edit_comment2'])) {
        $new_comment_text = mysqli_real_escape_string($connect, $_POST['comment_text']);
        $update_query = "UPDATE comments SET comment_text='$new_comment_text' WHERE id='$id'";
        mysqli_query($connect, $update_query);

        echo "<script> window.onload = function() {
            Swal.fire({
                title: 'Success!',
                text: 'Comment has been updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location.href = '../html/post-page.php?id=$post_id';
            });
        }</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/comments.css">
    <title>Edit Comment</title>
</head>
<body>
    <div class = "comments">
        <h2 class="add-comment-title">Edit Comment</h2>
    </div>
 <form class="comment-form" method="post" id="edit_comment_form" onsubmit="return AreYouSure();">
        <div class="form-group">
            <label for="comment_name">Username:</label>
            <input type="text" name="comment_name" id="comment_name" value="<?php echo $_POST['comment_name'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="comment_email">Email:</label>
            <input type="text" name="comment_email" id="comment_email" value="<?php echo $_POST['comment_email'] ?>" readonly>
        </div>
        <div class="form-group">
            <input type="hidden" name="comment_id" value="<?php echo $id?>">
            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
<label for="comment_text">Comment:</label>
<textarea name="comment_text" id="comment_text" rows="4"><?php echo $_POST['comment_text'] ?></textarea>
</div>
<input class="submit-button" type="submit" name="edit_comment2" value="Edit">
</form>

</body>
</html>
</body>
</html>
