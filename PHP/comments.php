<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer>
function deleteCommentPopUp(commentId) {
  Swal.fire({
    title: 'Delete Comment',
    text: "Are you sure you want to delete this comment?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire(
        'Deleted!',
        'Comment has been deleted.',
        'success'
      ).then(() => {
        // Delete the comment from the database
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../PHP/deleteComment.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`delete_comment=true&comment_id=${commentId}`);
        xhr.onload = function () {
          if (xhr.readyState === xhr.DONE) {
            if (xhr.status === 200) {
              location.reload(); // Reload the page to see the updated comments
            } else {
              console.error(xhr);
            }
          }
        };
      });
    }
  });
}

function validateComment(event) {
  var commentText = document.getElementById("comment_text").value;
  if (commentText.trim() === "") {
    Swal.fire({
      title: 'Error!',
      text: 'Please enter a comment!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return false;
  } 
}

</script>
<?php
// include('commentServer.php');
// session_start();
$connect = mysqli_connect("localhost", "root", "", "website_blog_hp");
mysqli_select_db($connect, "website_blog_hp");

if(isset($_SESSION['Email'])) {
// Get product ID
$id = null;
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $select = "SELECT * FROM products WHERE PID = '$id'";
  $query = mysqli_query($connect, $select);
  $row = mysqli_fetch_array($query);
}

// Get logged in user's email
if (isset($_SESSION['Email'])) {
  $comment_email = $_SESSION['Email'];
  // $comment_name = $_SESSION['Username'];
}

// Insert new comment
if (isset($_POST['submit_comment'])) {
  $comment_name = mysqli_real_escape_string($connect,$_POST['comment_name']);
  $comment_text = mysqli_real_escape_string($connect,$_POST['comment_text']);
  $insert_comment = "INSERT INTO comments (post_id, comment_name, comment_email, comment_text) VALUES ('$id', '$comment_name', '$comment_email', '$comment_text')";
  mysqli_query($connect, $insert_comment);
  echo "<script>
  Swal.fire({
    title: 'Success!',
    text: 'Comment has been posted!',
    icon: 'success'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '{$_SERVER['PHP_SELF']}?id={$id}';
    }
  });
</script>";
  exit();
}


// Get comments for this post
$select_comments = "SELECT * FROM comments WHERE post_id = '$id' ORDER BY comment_date DESC LIMIT 0,9";
$result = mysqli_query($connect, $select_comments);
?>

<h2>Comments</h2>

<?php if (mysqli_num_rows($result) > 0) { ?>
<?php while ($comment = mysqli_fetch_assoc($result)) { ?>

  <div class="comment">
  <div class="comment-info">
    <p><?php echo $comment['comment_name']; ?></p>
    <p><?php echo date("F j, Y, g:i a", strtotime($comment['comment_date'])); ?></p>
  </div>
  <p><?php echo $comment['comment_text']; ?></p>
  <?php if (isset($_SESSION['Email']) && $comment['comment_email'] == $_SESSION['Email'] || $_SESSION['Role'] == 1 ) { ?>
    <form action="../PHP/deleteComment.php" method="POST">
      <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
      <button type="button" name="delete_comment" onclick="deleteCommentPopUp('<?php echo $comment['id']; ?>')" class="delete-comment-button">Delete</button>
    </form>

  <form action="../PHP/editComment.php" method="POST">
    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
    <input type="hidden" name="post_id" value="<?php echo $comment['post_id']; ?>">
    <input type="hidden" name="comment_name" value="<?php echo $comment['comment_name']; ?>">
    <input type="hidden" name="comment_date" value="<?php echo $comment['comment_date']; ?>">
    <input type="hidden" name="comment_email" value="<?php echo $comment['comment_email']; ?>">
    <input type="hidden" name="comment_text" value="<?php echo $comment['comment_text']; ?>">
    <input type="submit" name="edit_comment" value="Edit" class="EditComment"> 
  </form>
  <?php } ?>
</div>




<?php } ?> 
<?php } else { ?>
  <p style="text-align: center; padding-top: 1rem; padding-bottom: 1rem;">No comments yet.</p>
<?php } ?>
<?php if($id != NULL) {?>
<!-- Add new comment form -->
<h2 class="add-comment-title">Add a comment</h2>

<form class="comment-form" id = "post-comment-form" action="" method="post" onsubmit="return validateComment(event);">
  <div class="form-group">
    <label for="comment_name">Username:</label>
    <input type="text" name="comment_name" id="comment_name" value="<?php
        include('connect.php');

        $email = $_SESSION['Email'];
        $sql = "SELECT Username FROM userregistration WHERE Email='$email'";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Username'];
        }
      ?>" readonly>
  </div>
  <div class = "form-group">
    <label for = "comment_email">Email:</label>
    <input type = "hidden" name="comment_email" value = "<?php echo $_SESSION['Email'];?>">
    <input type = "text" id="comment_email" value = "<?php echo $_SESSION['Email'];?>" readonly>
  </div>
  <div class="form-group">
    <label for="comment_text">Comment:</label>
    <textarea name="comment_text" id="comment_text" rows="4"></textarea>
  </div>
  <input class="submit-button" type="submit" name="submit_comment" value="Submit">
</form>
<?php }
}?>

<script src = "../js/comments.js"></script>