<?php 
  session_start();

    if(!isset($_SESSION['Email']) || $_SESSION['Role'] == 0 ) {
        header("location: ../../PHP/login.php");
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
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <link rel = "stylesheet" href="../writers/css/myBlogs.css">
    <title>Document</title>
</head>
<body>
    <h2 style = "text-align: center; margin-top: 2rem;">Your Blogs</h2>
    <section id="post-list" class="post container">
  <?php
    include("connect.php");
    $email = mysqli_real_escape_string($connect,$_SESSION['Email']);
    $select = "SELECT * FROM products WHERE Email = '$email'";
    $query = mysqli_query($connect, $select);
    $category = isset($_POST['category']) ? $_POST['category'] : 'all';
    while($row = mysqli_fetch_array($query)) {
        $fileId = $row['PID'];
        $fileName = $row['fileName'];
        $fileUpload = $row['fileUpload'];
        $description = substr($row['fileDescription'], 0, 300);
        $fileProfilePicture = $row['fileProfilePicture'];
        $filePersonalName = $row['filePersonalName'];
        $fileProductDate = date("F j, Y, g:i a", strtotime($row['productDate']));
        $fileCategories = $row['fileCategories'];
  ?>
  <div class="post-box" data-category="<?php echo $fileCategories ?>">
  <a href="<?php echo '../../html/post-page.php?id=' . $fileId;?>">
    <img src="../admin/file/<?php echo $fileUpload;?>" alt="" class="post-img">
  </a>
    <h2 class="category">
      <?php echo $fileCategories ?>
    </h2>
    <a href="<?php echo '../../html/post-page.php?id=' . $fileId;?>" class="post-title">
      <?php echo $fileName; ?>
    </a>
    <span class="post-date" id="creation-date">
      <?php echo $fileProductDate ?>
    </span>
    <p class="post-description">
      <?php echo $description; ?>
    </p>
    <div class="profile">
      <img src="../admin/file/<?php echo $fileProfilePicture;?>" alt="" class="profile-img">
      <span class="profile-name"> <?php echo $filePersonalName ?> </span>
    </div>
  </div>
  <?php } 
  }?>
</section>
</body>
</html>