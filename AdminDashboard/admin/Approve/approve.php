<?php 
    session_start();

    if(!isset($_SESSION['Email']) || $_SESSION['Role'] == 0 || $_SESSION['Role'] != 1) {
        header("location: ../../../PHP/login.php");
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel = "stylesheet" href="CSS/myBlogs.css">
    <link rel = "stylesheet" href="CSS/style.css">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="../../images/favicon2.png">
</head>
<script>
function deletePostPopUp(postId) {
  Swal.fire({
    title: 'Decline Blog',
    text: "Are you sure you want to decline this blog?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire(
        'Declined!',
        'Blog has been declined.',
        'success'
      ).then(() => {
        // Delete the post from the database
        fetch('delete.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `delete=true&post_id=${postId}`
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          location.reload(); // Reload the page to see the updated posts
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });
    }
  });
}
</script>
<body>
    <h2 style = "text-align: center; margin-top: 2rem;">Approve or Decline Blogs.</h2>
    <section id="post-list" class="post container">
  <?php
    include("../connect.php");
    // $email = mysqli_real_escape_string($connect,$_SESSION['Email']);
    $select = "SELECT * FROM userproducts";
    $query = mysqli_query($connect, $select);
    $category = isset($_POST['category']) ? $_POST['category'] : 'all';
    while($row = mysqli_fetch_array($query)) {
        $id = $row['PID'];
        $fileName = $row['fileName'];
        $fileUpload = $row['fileUpload'];
        $description = $row['fileDescription'];
        $fileProfilePicture = $row['fileProfilePicture'];
        $filePersonalName = $row['filePersonalName'];
        $fileProductDate = date("F j, Y, g:i a", strtotime($row['productDate']));
        $fileCategories = $row['fileCategories'];
  ?>
  <div class="post-box" data-category="<?php echo $fileCategories ?>">
  <a href="<?php echo 'viewBlog.php?id=' . $id;?>">
    <img src="file/<?php echo $fileUpload;?>" alt="" class="post-img">
  </a>
    <h2 class="category">
      <?php echo $fileCategories ?>
    </h2>
    <a href="<?php echo 'viewBlog.php?id=' . $id;?>" class="post-title">
      <?php echo $fileName; ?>
    </a>
    <span class="post-date" id="creation-date">
      <?php echo $fileProductDate ?>
    </span>
    <p class="post-description">
      <?php echo $description; ?>
    </p>
    <div class="profile">
      <img src="file/<?php echo $fileProfilePicture;?>" alt="" class="profile-img">
      <span class="profile-name"> <?php echo $filePersonalName ?> </span>
    </div>
    <form method="POST" action="approve.php" enctype="multipart/form-data">
  <input type="hidden" name="fileId" value="<?php echo $id; ?>">
  <input type="hidden" name="fileName" value="<?php echo $fileName; ?>">
  <input type="hidden" name="content" value="<?php echo $description; ?>">
  <input type="hidden" name="filePersonalName" value="<?php echo $filePersonalName; ?>">
  <input type="hidden" name="fileProductDate" value="<?php echo $fileProductDate; ?>">
  <input type="hidden" name="fileCategories" value="<?php echo $fileCategories; ?>">
  <label for = "fileUpload">File</label>
  <br>
  <input type="file" name="fileUpload" value="<?php echo $fileUpload; ?>">
  <br>
  <label for = "fileProfilePicture">Profile Picture</label>
  <br>
  <input type="file" name="fileProfilePicture" value="<?php echo $fileProfilePicture; ?>">
  
  <input class="submit-button approve-blog-button" type="submit" name="upload" value="Approve">
  
  <a class = "delete-blog-button" href="delete.php?delete=<?php echo $id; ?>" onclick="deletePostPopUp(<?php echo $id; ?>); return false;">Delete</a>
</form>
  </div>

  <?php }
  } ?>

</section>
<?php include("approveProd.php"); ?>
</body>
</html>