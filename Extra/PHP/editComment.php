<?php session_start(); 
    if(!isset($_SESSION['Email'])) {
        header("Location: login.php");
    }
    else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

// Retrieve the comment ID and edited text from the form submission
// $comment_id = $_POST['comment_id'];
$comment_name = $_POST['comment_name'];
// $comment_date = $_POST['comment_date'];
$comment_text = $_POST['comment_text'];
// $edited_text = $_POST['edit-comment'];
if (isset($_POST['edit_comment'])) {
function editComments() {
        $connect=mysqli_connect('localhost','root','','website_blog_hp');
        mysqli_select_db($connect,'website_blog_hp');
        $id = $_GET['id'];
        $cid = $_POST['comment_id'];
        $comment_name = mysqli_real_escape_string($connect,$_POST['comment_name']); 
        $comment_text = mysqli_real_escape_string($connect,$_POST['comment_text']);
        $comment_date = mysqli_real_escape_string($connect,$_POST['comment_date']);
      
        $insert_comment = "UPDATE comments SET comment_text = '$comment_text' WHERE id = '$cid' ";
        mysqli_query($connect, $insert_comment);
        if(mysqli_affected_rows($connect) == 1) {
        echo "<script> alert('Comment edited successfully!') </script>";
        }
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id);
        exit();
      }
}

echo '
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

<form class="comment-form" method="post" onsubmit="return validateComment()" action="editComment.php">
  <div class="form-group">
    <label for="comment_name">Username:</label>
    <input type="text" name="comment_name" id="comment_name" value="';
        $connect=mysqli_connect('localhost','root','','website_blog_hp');
        mysqli_select_db($connect,'website_blog_hp');

        $email = $_SESSION['Email'];
        $sql = "SELECT Username FROM userregistration WHERE Email='$email'";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Username'];
        }
echo '" readonly>
  </div>
  <div class = "form-group">
    <label for = "comment_email">Email:</label>
    <input type = "text" name="comment_email" id="comment_email" value = "'. $_SESSION['Email'] .'" readonly>

  </div>
  <div class="form-group">
    <label for="comment_text">Comment:</label>
    <textarea name="comment_text" id="comment_text" rows="4">"'.$comment_text.'"</textarea>
  </div>
  <input class="submit-button" type="submit" name="edit_comment" onclick = "return confirm(\'Are you sure you want to update this comment?\')" value="Edit">
</form>';
// Update the comment in the database
// $conn = mysqli_connect("localhost","root","","website_blog_hp");
// mysqli_select_db($conn,"website_blog_hp"); 
// if (!empty($_POST['edit-comment'])) {
// $stmt = mysqli_prepare($conn, "UPDATE comments SET comment_text = ? WHERE comment_id = ?");
// mysqli_stmt_bind_param($stmt, "si", $edited_text, $comment_id);
// mysqli_stmt_execute($stmt);
// mysqli_stmt_close($stmt);
// mysqli_close($conn);
// }

// Redirect back to the current page
// header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
}
?> 

</body>
</html>