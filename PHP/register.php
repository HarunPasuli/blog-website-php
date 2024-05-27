<?php
if(isset($_SESSION['Email'])) {
  session_destroy();
}
// include('server.php');
  // if(isset($_SESSION['Email'])) {
  //   // echo "<script> alert('You must log out of your account first!') </script>";
  //   // echo "<script> window.open('../html/index.php','_self') </script>";
  //   exit();
  // }
  // else {
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/register.css">
    <script src = "../js/register.js" defer></script>
    <title>Register</title>
</head>
<body>
<form method="post" onsubmit="return checkBeforeSubmit()">
  <h2>Register</h2>
  <div class="input-container">
    <label for="username">Username: </label>
    <input type="text" id="username" name="Username" required>
  </div>
  <div class="input-container">
    <label for="email">Email: </label>
    <input type="email" id="email" name="Email" required>
  </div>
  <div class="input-container">
    <label for="password">Password: </label>
    <div class="password-input-container">
      <input type="password" id="password" name="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required>
      <span class="password-info-icon">&#63;</span>
      <div class="password-info-box">
        <ul>
          <li>At least 8 characters</li>
          <li>At least one uppercase letter</li>
          <li>At least one lowercase letter</li>
          <li>At least one number</li>
        </ul>
      </div>
    </div>
  </div>
  <button type="submit" name = "login" value = "Log in">Register</button>
  <div class="login-link">
    <span>Already registered?</span> <a href="login.php">Login</a>
  </div>
</form>
<script> 
            var wasSubmitted = false;
            function checkBeforeSubmit() {
                if(!wasSubmitted) {
                    wasSubmitted = true;
                    return wasSubmitted;
                }
                return false;
            }
        </script>
<?php
    function validatePassword($password) {
      $hasLength = strlen($password) >= 8;
      $hasUpperCase = preg_match('/[A-Z]/', $password);
      $hasLowerCase = preg_match('/[a-z]/', $password);
      $hasNumber = preg_match('/\d/', $password);
      
      $criteriaMet = $hasLength && $hasUpperCase && $hasLowerCase && $hasNumber;
      
      return $criteriaMet;
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $password = $_POST["Password"];

      if (!validatePassword($password)) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'Password does not meet the criteria!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
          window.open('register.php','_self');
        });
        </script>";
        exit();
      } 
      
    }
  // }
  include('server.php'); 
  ?>
</body>
</html>