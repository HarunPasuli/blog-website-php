<?php 
    session_start(); 
    if(!isset($_SESSION['Email'])) {
        header("Location: login.php");
    }
    else {
        if (isset($_POST['edit_comment'])) {
            function editComments() {
                $connect=mysqli_connect('localhost','root','','website_blog_hp');
                mysqli_select_db($connect,'website_blog_hp');
                $cid = $_POST['comment_id'];
                $post_id = $_POST['post_id'];
                $comment_name = mysqli_real_escape_string($connect,$_POST['comment_name']); 
                $comment_text = mysqli_real_escape_string($connect,$_POST['comment_text']);
                
                $insert_comment = "UPDATE comments SET comment_text = '$comment_text' WHERE id = '$cid' ";
                mysqli_query($connect, $insert_comment);
                if(mysqli_affected_rows($connect) == 0) {
                    echo "<script> alert('Comment wasn't edited!') </script>";
                }
                header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $post_id['id']);
                exit();
            }
            
            editComments();
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
</head>
<body>
    <h2 class="add-comment-title">Edit Comment</h2>
    <script>
        function validateComment() {
            var commentText = document.getElementById("comment_text").value;
            if (commentText.trim() === "") {
                alert("Please enter a comment.");
                return false;
            }
            return true;
        }
    </script>
    
    <form class="comment-form" method="post" onsubmit="return validateComment()" action="">
    <div class="form-group">
    <label for="comment_name">Username:</label>
    <input type="text" name="comment_name" id="comment_name" value="<?php
        $connect=mysqli_connect('localhost','root','','website_blog_hp');
        mysqli_select_db($connect,'website_blog_hp');

        $email = $_SESSION['Email'];
        $sql = "SELECT Username FROM userregistration WHERE Email='$email'";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Username'];
        }
      ?>" readonly>
  </div>
        <div class="form-group">
            <label for="comment_email">Email:</label>
            <input type="text" name="comment_email" id="comment_email" value="<?php echo $_SESSION['Email']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="comment_text">Comment:</label>
            <textarea name="comment_text" id="comment_text" rows="4"><?php echo $comment['comment_text']; ?></textarea>
        </div>
        <input class="submit-button" type="submit" name="edit_comment" onclick="return confirm('Are you sure you want to update this comment?')" value="Edit">
        <input type="hidden" name="comment_id" value="<?php echo $_GET['id']; ?>">
    </form>
</body>
</html>

<?php 
    }
?>
