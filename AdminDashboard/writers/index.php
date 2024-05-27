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
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <title>Writers Dashboard</title>
</head>

<body>
<div class="container">
  <div class="card">
    <img src="https://via.placeholder.com/300x200.png?text=Insert+Products" alt="Insert Products">
    <div class="card-body">
      <h2>Insert Products</h2>
      <p>Insert New Products To The Blog Website.</p>
      <a href="insert.php">Get Started</a>
    </div>
  </div>
  <div class="card">
    <img src="https://via.placeholder.com/300x200.png?text=View+Products" alt="View Products">
    <div class="card-body">
      <h2>View Products</h2>
      <p>Manage and view your existing products.</p>
      <a href="view.php">Get Started</a>
    </div>
  </div>
  <div class="card">
    <img src="https://via.placeholder.com/300x200.png?text=My Blogs" alt="My Blogs">
    <div class="card-body">
      <h2>My Blogs</h2>
      <p>Check out all of the blogs that you have written.</p>
      <a href="myBlogs.php">My Blogs</a>
    </div>
  </div>
  <div class="card">
    <img src="https://via.placeholder.com/300x200.png?text=Resize+Image" alt="Resize Image">
    <div class="card-body">
      <h2>Resize Image</h2>
      <p>Resize The Width and Height Of An Image</p>
      <a href="image resizer/index.html">Resize Image</a>
    </div>
  </div>
  <div class="card">
    <img src="https://via.placeholder.com/300x200.png?text=Main+Page" alt="Main Page">
    <div class="card-body">
      <h2>Main Page</h2>
      <p>Go To The Main Page Of The Website</p>
      <a href="../../html/index.php">Main Page</a>
    </div>
  </div>
  <div class="card">
    <img src="https://via.placeholder.com/300x200.png?text=Logout" alt="Logout">
    <div class="card-body">
      <h2>Logout</h2>
      <p>Log out of your writers account. </p>
      <a href="logout.php">Log Out</a>
    </div>
  </div>
</div>

<?php
    }
?>  
</body>
</html>