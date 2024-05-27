<?php 
    session_start();
    ob_start();
    // if (!isset($_SESSION['Email'])) {
    //     header("Location: ../php/login.php");
    //     exit;
    // }
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    $connect = mysqli_connect("localhost", "root", "", "website_blog_hp");
    mysqli_select_db($connect, "website_blog_hp");
    $id = null;
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $select = "SELECT * FROM products WHERE PID = '$id'";

        $query = mysqli_query($connect, $select);

        if(mysqli_num_rows($query) == 0) {
          echo "<h2 style = 'text-align: center;'>Nuk ka rezultat</h2>";
          exit();
      }

        $row = mysqli_fetch_array($query);

        $fileName = $row['fileName'];
        echo "<title>$fileName</title>";
    }
    ?>
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dropdown.css">
    <link rel="stylesheet" href="../css/comments.css">
    <link rel="stylesheet" href="../css/modal3.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/fad4869f0d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php if($id != NULL) {?>
  <header>
  <div class="nav container">
    <a href="../index.php" class="logo">Ha<span>run</span></a>

    <?php
    if (isset($_SESSION['Email'])) {
      ?>
      <div class = "dropdown">
      <a href="#" class="login">
        <?php     
        include('../PHP/connect.php');

        $email = $_SESSION['Email'];
        $sql = "SELECT Username FROM userregistration WHERE Email='$email'";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Username'];
        } ?>
        </a>
        <div class="dropdown-content">
          <?php 
          if($_SESSION['Role'] == 1) {
            echo "<a href = '../php/profile.php'> Profile </a>";
          }
          if($_SESSION['Role'] == 2) {
            echo "<a href = '../php/profile.php'> Profile </a>";
          }
          ?>
          <a href="../mail/Send email/send.php">Contact Us</a>
          <form action="../PHP/search.php" method="GET">
          <input type="text" placeholder="Search posts..." name="search">
          <!-- <button type="submit" name="submit-search"><i class="bx bx-search"></i></button> -->
        </form>
          <?php 
            if($_SESSION['Role'] == 1) {
              echo "<a href = '../AdminDashboard/admin/index.php'> Admin Dashboard </a>";
            }
            if($_SESSION['Role'] == 2) {
              echo "<a href = '../AdminDashboard/admin/index.php'> Writer Dashboard </a>";
            }
            else {
              echo "<a href = '../user/UserInsert.php'> Send a Blog </a>";
            }
          ?>
          <a href="../php/logout.php">Logout</a>
        </div>
      <!-- </a> -->
      </div>
    <?php } else { ?>
      <a href="../php/login.php" class="login">Login</a>
    <?php } ?>
  </div>
</header>



    <?php
    $connect = mysqli_connect("localhost", "root", "", "website_blog_hp");
    mysqli_select_db($connect, "website_blog_hp");

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $select = "SELECT * FROM products WHERE PID = '$id'";

        $query = mysqli_query($connect, $select);

        $row = mysqli_fetch_array($query);

        $fileId = $row['PID'];
        $fileName = $row['fileName'];
        $fileUpload = $row['fileUpload'];
        $description = $row['fileDescription'];
        $fileProfilePicture = $row['fileProfilePicture'];
        $filePersonalName = $row['filePersonalName'];
        $fileCategories = $row['fileCategories'];
    ?>

    <section class="post-header">
        <div class="header-content post-container">
            <a href="../index.php" class="back-home">Back To Home</a>
            <h1 class="header-title"> <?php echo $fileName ?> </h1>
            <img src="../AdminDashboard/admin/file/<?php echo $fileUpload;?>" alt="" class="header-img">
        </div>
    </section>

    <section class="post-content post-container">
        <h2 class = "category" style = "text-align: center;"> <?php echo $fileCategories ?> </h2>
        <h2 class="sub-heading"> <?php echo $fileName ?> </h2>
        <p class="post-text"> <?php echo nl2br($description) ?> </p>
        <div class="profile">
                <img src="../AdminDashboard/admin/file/<?php echo $fileProfilePicture;?>" alt="" class="profile-img">
                <span class="profile-name"> <?php echo $filePersonalName ?> </span>
            </div>
    <?php } ?>
    </section>

    <?php include('../PHP/comments.php'); ?>
    <!-- <script src = "../js/comments.js"></script> -->

    <div class="footer container">
    <p>Copyright &copy; <?php echo date("Y")?> Harun Pasuli All Rights Reserved</p>
        <div class="social">
            <a href="https://www.facebook.com/shkolladigjitale" target = "_blank"><i class="bx bxl-facebook"></i></a>
            <a href="#" id="share-link"><i class='bx bx-share-alt'></i></a>
            <div id="share-modal" class="modal">
  <div class="modal-content">
    <h2>Share Link</h2>
    <p>Copy the link below to share:</p>
    <input type="text" id="share-url">
    <button id="copy-btn">Copy Link</button>
    <div id="share-buttons">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<%=encodeURIComponent(window.location.href)%>" target="_blank"><i class="bx bxl-facebook"></i></a>
      <a href="https://www.twitter.com/share?url=<%=encodeURIComponent(window.location.href)%>" target="_blank"><i class="bx bxl-twitter"></i></a>
      <a href="https://www.linkedin.com/shareArticle?url=<%=encodeURIComponent(window.location.href)%>" target="_blank"><i class="bx bxl-linkedin"></i></a>
    </div>
  </div>
</div>
                <script src = "../JS/modal.js" defer></script>
            <a href="https://www.instagram.com/shkolladigjitaleofficial/" target = "_blank"><i class="bx bxl-instagram"></i></a>
            <a href="https://www.linkedin.com/company/shkolladigjitale/" target = "_blank"><i class="bx bxl-linkedin"></i></a>
        </div>
    </div>  
  <?php }?>


    <script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
    <script src = "../js/script.js" defer></script>
</body>
</html>