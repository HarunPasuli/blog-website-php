<?php 
    session_start();
    ini_set('display_errors', 1);
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
    <title>Forgot Password</title>
</head>
<body>
<div class="login-container">
        <h2>Enter Email</h2>
        <form method = "post">
          <div class="input-container">
            <label for="email">Email: </label>
            <div>
                <input type = "text" id = "email" name = "Email" required>
            </div>
          </div>
          <button type="submit" name = "sendPassword" value = "sendPassword">Confirm</button>
        </form>
        <div class="register-link">
          <p>Already have an account? <a href="login.php">Click here to login!</a></p>
        </div>
      </div>     
    
      <?php 
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        
        require '../mail/Send email/PHPMailer/src/Exception.php';
        require '../mail/Send email/PHPMailer/src/PHPMailer.php';
        require '../mail/Send email/PHPMailer/src/SMTP.php';
        require 'C:/xampp/phpMyAdmin/vendor/autoload.php';

        if(isset($_POST['sendPassword'])) {
            $email = $_POST['Email'];
    
            $conn = mysqli_connect("localhost","root","","website_blog_hp");
            mysqli_select_db($conn,"website_blog_hp"); 

            $stmt = $conn->prepare("SELECT * FROM `userregistration` WHERE Email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = mysqli_fetch_assoc($result);
            
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Invalid email format!',
                  icon: 'error',
                  confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('forgotPassword.php','_self');
                });
                </script>";
                exit();
            }

            if (!$user) {
                    echo "<script>
                    Swal.fire({
                      title: 'Error!',
                      text: 'Email doesn\'t exist! Please enter a valid email address.',
                      icon: 'error',
                      confirmButtonText: 'OK'
                    }).then((result) => {
                      window.open('forgotPassword.php','_self');
                    });
                    </script>";
                    exit();
            }

            if ($user) {
        $token = bin2hex(random_bytes(32));
        $stmt = $conn->prepare("UPDATE `userregistration` SET token = ? WHERE Email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        
        // Construct the email message with a link to the password reset page
        $resetLink = "localhost/xampp%20-%20HP%202/ICT/PHP/resetPassword.php?token=$token";
        $mail = new PHPMailer;
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mitlapiz@gmail.com';
            $mail->Password = 'sfajfxfddgdtmoim';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('mitlapiz@gmail.com','gmail');
            $mail->addAddress($email, $user['Username']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password reset request';
            $mail->Body    = "Hi {$user['Username']},<br><br>
            You recently requested to reset your password. Click the link below to reset your password.<br><br>
            <a href='{$resetLink}'>Reset Password'</a><br><br>
            If you didn't request a password reset, please ignore this email.<br><br>
            Best regards,<br>
            Harun Blog";
            
            if(!$mail->send()) {
                echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to send email! Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('forgotPassword.php','_self');
                });
                </script>";
            } 
            else {
                echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'An email has been sent to your registered email address. Please follow the instructions in the email to reset your password.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('forgotPassword.php','_self');
                });
                </script>";
            }
        }
    }
?>
</body>
</html>