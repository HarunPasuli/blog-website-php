<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
include('connect.php');

if (isset($_SESSION['Email']) && isset($_POST['delete_comment'])) {
  $comment_id = mysqli_real_escape_string($connect, $_POST['comment_id']);
  $comment_email = mysqli_real_escape_string($connect, $_SESSION['Email']);

  $select_comment = "SELECT * FROM comments WHERE id='$comment_id' AND comment_email='$comment_email'";
  $result = mysqli_query($connect, $select_comment);
  
  if (mysqli_num_rows($result) > 0) {
    $delete_comment = "DELETE FROM comments WHERE id='$comment_id'";
    mysqli_query($connect, $delete_comment);
  }
}

header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the previous page
exit;
?>
