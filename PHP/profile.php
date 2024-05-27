<?php
  session_start();
  // include('server.php');

  if (!isset($_SESSION['Email']) || $_SESSION['Role'] == 0) {
    header("Location: login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../images/favicon2.png"> 
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../css/profile.css">
  <title>Profile</title>
</head>
<body>
  <div class="profile-tab">
    <a href="../index.php">Go Home</a> 
    <h2>Update Profile</h2>
    <form method="POST" action="">
      <?php
        $username = "";
        if(isset($_SESSION['Username'])) {
          include('connect.php');
          $username = $_SESSION['Username'];
          $sql = "SELECT Username FROM userregistration WHERE Username='$username'";
          $result = mysqli_query($connect, $sql);
          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['Username'];
          }
        }
      ?>
      <label for="Username">Username:</label>
      <input type="text" name="Username" value="<?php
         include('connect.php');

        $email = $_SESSION['Email'];
        $sql = "SELECT Username FROM userregistration WHERE Email='$email'";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row['Username'];
        }
      ?>">

      <label for="email">Email:</label>
      <input type="email" name="Email" value="<?php echo $_SESSION['Email']; ?>">

      <label for="password">New Password:</label>
      <input type="password" name="Password" value="" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$">

      <input type="submit" name="update" value="Update Profile">
    </form>
  </div>

  <?php
        include('connect.php');

    if(isset($_SESSION['Email'])) {
      $email = $_SESSION['Email'];
      $query = "SELECT * FROM userregistration WHERE Email = '$email'";
      $result = mysqli_query($connect, $query);

      if(mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $name = $row['Username'];
          $email = $row['Email'];
          $UID = $row['UID'];
      }
    }

    if(isset($_POST['update'])) {
      $name = mysqli_real_escape_string($connect,$_POST['Username']);
      $email = mysqli_real_escape_string($connect,$_POST['Email']);
      $password = mysqli_real_escape_string($connect, $_POST['Password']);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the new password

      if(isset($UID)) {
        if(!empty($password)) {
          $query = "UPDATE userregistration SET Username='$name', Email='$email', Password='$hashed_password' WHERE UID='$UID'";
          $result = mysqli_query($connect, $query);
        }
        else {
          $query = "UPDATE userregistration SET Username='$name', Email='$email' WHERE UID='$UID'";
          $result = mysqli_query($connect, $query);
        }
          if($result) {
            echo "<script>
            Swal.fire({
              title: 'Success!',
              text: 'Profile updated successfully!',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then((result) => {
              window.open('login.php','_self');
            });
            </script>";
            session_destroy();
            exit();
          } else {
            echo "<script>
            Swal.fire({
              title: 'Error!',
              text: 'There was an error updating your profile!',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then((result) => {
              return false;
            });
            </script>";
            exit();
          }
      } else {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'UID not set!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
          return false;
        });
        </script>";
        exit();
      }
  }
  
    ?>
    
    </body>
    </html>    
