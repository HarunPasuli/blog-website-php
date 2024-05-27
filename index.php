<?php
    session_start();
    include('PHP/connect.php');
    $email = $_SESSION['Email'];
    $email = mysqli_real_escape_string($connect, $email);
    $query = "SELECT email_verified_at FROM userregistration WHERE Email = '$email'";
    $result = mysqli_query($connect, $query);
    if (!$result) {
      header("Location: php/login.php");
      exit;
  }
  
  $row = mysqli_fetch_assoc($result);
  
  if (!$row || empty($row['email_verified_at'])) {
      header("Location: php/login.php");
      exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon2.png">
    <title>Blog Website</title>
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="css/comments.css">
    <link rel="stylesheet" href="css/button.css">
    <link rel="stylesheet" href="css/modal2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<header>
  <div class="nav container">
    <a href="index.php" class="logo">Ha<span>run</span></a>

    <?php
    if (isset($_SESSION['Email'])) {
      ?>
      <div class = "dropdown">
      <a href="#" class="login">
        <?php    
        include('PHP/connect.php');

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
            echo "<a href = 'php/profile.php'> Profile </a>";
          }
          if($_SESSION['Role'] == 2) {
            echo "<a href = 'php/profile.php'> Profile </a>";
          }
          ?>
          <a href="mail/Send email/send.php">Contact Us</a>
          <form action="PHP/search.php" method="GET">
          <input type="text" placeholder="Search posts..." name="search">
          <!-- <button type="submit" name="submit-search"><i class="bx bx-search"></i></button> -->
        </form>
          <?php 
            if($_SESSION['Role'] == 1) {
              echo "<a href = 'AdminDashboard/admin/index.php'> Admin Dashboard </a>";
            }
            if($_SESSION['Role'] == 2) {
              echo "<a href = 'AdminDashboard/admin/index.php'> Writer Dashboard </a>";
            }
            else {
              echo "<a href = 'user/UserInsert.php'> Send a Blog </a>";
            }
          ?>
          <a href="php/logout.php">Logout</a>
        </div>
      <!-- </a> -->
      </div>
    <?php } else { ?>
      <a href="php/login.php" class="login">Login</a>
    <?php } ?>
  </div>
</header>



   <!-- <div id="myModal" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span> 
      <p>You need to be logged in before accessing the website.</p>
    </div>
  </div>
  <script>
    // Check if user is logged in
    <?php if(!isset($_SESSION['Email'])) { ?>
      // Get the modal
      var modal = document.getElementById("myModal");
  
      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];
  
      // When the user clicks on the button, open the modal
      modal.style.display = "block";
  
      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      }
  
      // When the user clicks anywhere outside of the modal, close it
      // window.onclick = function(event) {
      //   if (event.target == modal) {
      //     modal.style.display = "none";
      //   }
      // }
    <?php } ?>
  </script> -->
  

    <section class="home" id="home">
        <div class="home-text container">
            <h2 class="home-title">The Harun Blog</h2>
            <span class="home-subtitle">Your source of great content</span>
        </div>
    </section>

<div class="post-filter container">
    <span class="filter-item active-filter" data-filter="all">All</span>
    <span class="filter-item" data-filter="Design">Design</span>
    <span class="filter-item" data-filter="Tech">Tech</span>
    <span class="filter-item" data-filter="Mobile">Mobile</span>
    <span class="filter-item" data-filter="Gaming">Gaming</span>
    <span class="filter-item" data-filter="Anime">Anime</span>
    <span class="filter-item" data-filter="Programming">Programming</span>
    <span class="filter-item" data-filter="Sports">Sports</span>
    <span class="filter-item" data-filter="News">News</span>
</div>
<!--  -->

<section id="post-list" class="post container">
  <?php
    include("AdminDashboard/admin/connect.php");
    $select = "SELECT * FROM products order by PID DESC LIMIT 0,9";
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
  <a href="<?php echo 'html/post-page.php?id=' . $fileId;?>">
    <img src="AdminDashboard/admin/file/<?php echo $fileUpload;?>" alt="" class="post-img">
  </a>
    <h2 class="category">
      <?php echo $fileCategories ?>
    </h2>
    <a href="<?php echo 'html/post-page.php?id=' . $fileId;?>" class="post-title">
      <?php echo substr($fileName,0,40); ?>
    </a>
    <span class="post-date" id="creation-date">
      <?php echo $fileProductDate ?>
    </span>
    <p class="post-description">
      <?php echo $description; ?>
    </p>
    <div class="profile">
      <img src="AdminDashboard/admin/file/<?php echo $fileProfilePicture;?>" alt="" class="profile-img">
      <span class="profile-name"> <?php echo $filePersonalName ?> </span>
    </div>
  </div>
  <?php } ?>
</section>

<div class="show_more_btn_container">
  <div class="show_more_btn">
    <button type="button" id="<?php echo $fileId; ?>" data-category="<?php echo $category; ?>" class="btn btn-primary">Load More</button>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".btn-primary", function() {
  var lastId = $(this).attr("id");
  var category = $('#post-list').attr('data-category'); // Get current category
  // $('.btn-primary').html("<img src='ajax-loader.gif' height='25px' width='25px'>");
  $(".show_more_btn_container").remove();
  $.ajax({
    url: "html/load_more.php",
    method: "POST",
    data: {
      PID: lastId,
      category: category // Pass current category to load_more.php
    },
    dataType: "text",
    success: function(data) {
      if (data != "") {
        $(".show_more_btn_container").remove();
        $(".show_more_btn").remove();
        $("#post-list").append(data);
        $("#post-list .show_more_btn").addClass("show_more_btn_container");
      } else {
        $(".btn-primary").attr("disabled", true).html("No More Data");
      }
    }
  });
});

</script>

<script>
const filterButtons = document.querySelectorAll('.filter-item');
const postList = document.getElementById('post-list');

// Fetch products from the database based on category
const fetchProducts = (category) => {
  fetch('html/fetch-products.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `category=${category}`,
  })
    .then((response) => response.text())
    .then((html) => {
      postList.innerHTML = html;
      $(".show_more_btn_container").remove();
      postList.setAttribute('data-category', category); // Add category attribute to postList
      // Reinitialize the click event for the "Show More" button
      $(document).on("click", ".btn-primary", function() {
        var lastId = $(this).attr("id");
        var category = $('#post-list').attr('data-category'); // Get current category
        // $('.btn-primary').html("<img src='ajax-loader.gif' height='25px' width='25px'>");
        $.ajax({
          url: "html/load_more.php",
          method: "POST",
          data: {
            PID: lastId,
            category: category // Pass current category to load_more.php
          },
          dataType: "text",
          success: function(data) {
            if (data != "") {
              // $(".show_more_btn_container").remove();
              // $("#post-list").append(data);
              $("#post-list .show_more_btn").addClass("show_more_btn_container");
            } else {
              $(".btn-primary").attr("disabled", true).html("No More Data");
            }
          }
        });
      });
    })
    .catch((error) => console.error(error));
};

filterButtons.forEach(button => {
  button.addEventListener('click', () => {
    // Get the category from the clicked filter button
    const category = button.getAttribute('data-filter');

    // Fetch products based on the category
    fetchProducts(category);

    // Remove active class from all filter buttons
    filterButtons.forEach(button => {
      button.classList.remove('active-filter');
    });

    // Add active class to the clicked filter button
    button.classList.add('active-filter');
  });
});
</script>

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
            <script src = "JS/modal.js" defer></script>
            <a href="https://www.instagram.com/shkolladigjitaleofficial/" target = "_blank"><i class="bx bxl-instagram"></i></a>
            <a href="https://www.linkedin.com/company/shkolladigjitale/" target = "_blank"><i class="bx bxl-linkedin"></i></a>
        </div>
    </div>


</script>

    
    <script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
    <script src = "js/script.js" defer></script>
</body>
</html>