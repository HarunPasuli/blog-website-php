<?php 
  session_start();
  if(isset($_SESSION['Email'])) {
    $email = $_SESSION['Email'];
  }
  else {
    header('Location: ../PHP/email-verification2.php');
    exit();
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
    <link rel="stylesheet" href="../css/email-verfication.css">
    <title>Email Verification</title>
</head>
<body>
<div class="login-container">
        <h2>One Time Password</h2>
        <form method = "post">
        <!-- <div class="input-container"> -->
            <!-- <label for="email">Email:</label> -->
            <!-- <?php echo $email ?> -->
          <!-- </div> -->
          <input type = "hidden" id = "email" name = "Email" required value = "<?php echo $email ?>">
          <div class="input-container">
            <label for="password">One Time Password: </label>
            <div>
              <input type="text" id="password" name="verification_code" required>
            </div>
          </div>
          <button type="submit" name = "verify_email" value = "verify_email">Confirm</button>
        </form>
        <div class="register-link">
          <p>Already have an account? <a href="login.php">Click here to login!</a></p>
        </div>
      </div>     
    
    <?php 
        if(isset($_POST['verify_email'])) {
            $email = $_POST['Email'];
            $verification_code = $_POST['verification_code'];
    
            include('connect.php');
    
            $sql = "UPDATE userregistration SET email_verified_at = NOW() WHERE Email = '$email' AND verification_code = '$verification_code' ";
            $result = mysqli_query($connect,$sql);
    
            if(mysqli_affected_rows($connect) == 0) {
              echo "<script>
              Swal.fire({
                title: 'Error!',
                text: 'Confirmation failed, try again!',
                icon: 'error',
                confirmButtonText: 'OK'
              }).then((result) => {
                return false;
              });
              </script>";
              exit();
            }
            
            echo "<script>
            Swal.fire({
              title: 'Confirmation Successful!',
              text: 'Successfully Confirmed! You may now login your account!',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then((result) => {
                window.open('login.php','_self');
            });
            </script>";
            exit();
        }
    ?>
</body>
</html>