<?php
  session_start();
  // if(isset($_SESSION['Email'])) {
  //   echo "<script> alert('You must log out of your account first!') </script>";
  //   echo "<script> window.open('../html/index.php','_self') </script>";
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
    <link rel="stylesheet" href="../css/login.css">
    <script src = "../js/togglePassword.js" defer></script>
    <title>Login</title>
</head>
<body>
  
    <div class="login-container">
        <h2>Login</h2>
        <form method = "post">
          <div class="input-container">
            <label for="email">Email:</label>
            <input type="text" id="email" name="Email" required>
          </div>
          <div class="input-container">
            <label for="password">Password: </label>
            <div>
              <input type="password" id="password" name="Password" required>
              <svg xmlns="http://www.w3.org/2000/svg" id="eye" width="24" height="24" viewBox="0 0 24 24" onclick="document.querySelector('#eye path').setAttribute('d', 'M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z');">
  <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/>
</svg>

            </div>
          </div>
          <button type="submit" id = "loginInput" name = "login" value = "Log in">Login</button>
        </form>
        <div class="register-link">
          <p>Not registered? <a href="register.php">Click here to register!</a></p>
          <p>Verify your account <a href = "email-verification.php">here.</a></p>
        </div>
      </div>     
      
      <?php
// session_start();

include('connect.php');

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($connect, $_POST['Username']);
    $email = mysqli_real_escape_string($connect, $_POST['Email']);
    $password = mysqli_real_escape_string($connect, $_POST['Password']);

    $login = "SELECT * FROM userregistration WHERE Email = '$email'";
    $result = mysqli_query($connect, $login);
    
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['Password'];
        
        if(password_verify($password, $hashed_password))
        {
            if($row['email_verified_at'] == null) {
                $text = "Please verify your account <a href=\"email-verification.php\">here</a>!";
                $decoded_text = html_entity_decode($text);
        
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        html: '$decoded_text',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        window.open('login.php','_self');
                    });
                    </script>";
                exit();
            }
        
            // Set session variables and redirect based on user role
            $_SESSION['Username'] = $username;
            $_SESSION['Email'] = $email;
            $_SESSION['Login'] = $username; 
            $_SESSION['Role'] = $row['Role'];
            if ($row['Role'] == 0) { 
              echo "<script>
              window.open('../index.php','_self');
              </script>";
            }
            if ($row['Role'] == 1) {
              echo "<script>
              window.open('../AdminDashboard/admin/index.php','_self');
              </script>";
            }
            if ($row['Role'] == 2) {
              echo "<script>
              window.open('../AdminDashboard/admin/index.php','_self');
              </script>";
            }
        }
        else
        {
          $text2 = "Forgot Password? Reset password <a href=\"forgotPassword.php\" style = \"padding-left: 5px;\">here</a>!";
          $decoded_text2 = html_entity_decode($text2);
          echo "<script>
          Swal.fire({
            title: 'Error!',
            text: 'Email or Password are incorrect!',
            icon: 'error',
            footer: '$text2',
            confirmButtonText: 'OK'
          }).then((result) => {
            return false;
          });
          </script>";
            // echo "<script> window.open('login.php','_self') </script>";
            exit();
        }
    }
    else {
      // echo "<script> alert('Invalid email');</script>";
      echo "<script>
      Swal.fire({
        title: 'Error!',
        text: 'Please enter a valid email!',
        icon: 'error',
        confirmButtonText: 'OK'
      }).then((result) => {
        return false;
      });
      </script>";
      // echo "<script> window.open('login.php','_self') </script>";
      exit();
  }
} 
// }
?>


</body>
</html>