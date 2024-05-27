<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
	session_start();
	if (!isset($_SESSION['Email'])) {
        echo "<script>
        window.onload = function() {
            Swal.fire({
              title: 'Error!',
              text: 'You must be logged in before sending an email!',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then((result) => {
              window.open('../../php/login.php','_self');
            });
        }
        </script>";
        exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Send Email</title>
	<link rel="stylesheet" type="text/css" href="../../css/Mailer.css">	
  <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<body>
	<div class="form-wrap">
			<form action="" method="post" enctype="multipart/form-data" onsubmit = "return checkBeforeSubmit()">
				<h2>Send Email</h2>
				<label for="email">Email: </label>
				<input type="text" name="email"  value = "<?php echo $_SESSION['Email'];?>" id="emailphp" readonly/><br><br>

				<label for="subject">Subject: </label>
				<input type="text" name="subject" value="" id="subjectphp" required /><br><br>

				<label for="message">Your Message: </label>
				<textarea  name="message" value="Your Message" id="messagephp" required></textarea><br>	<br>		
				<input type="submit" name ="submit" value="Send!"/>
				<a href="../../html/index.php">Go Home</a>
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
	</div>
	<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer;

if (isset($_POST['submit'])) {
    $emailinp = $_POST['email'];
    $subjectinp = $_POST['subject'];
    $messageinp = $_POST['message'];

    if (empty($emailinp) || empty($subjectinp) || empty($messageinp)) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'One of the fields is empty!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
          window.open('send.php','_self');
        });
        </script>";
        exit();
    } elseif (!filter_var($emailinp, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'Email is not valid!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
          window.open('send.php','_self');
        });
        </script>";
        exit();
    } elseif ($emailinp != $_SESSION['Email']) {
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'The email you entered does not match the email associated with this session.',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
          window.open('send.php','_self');
        });
        </script>";
        exit();
    } else {

$mail->SMTPDebug = 4;
$mail->isSMTP();

$mail->Host = 'smtp.gmail.com';

$mail->SMTPAuth = true;

$mail->Username = 'mitlapiz@gmail.com';
$mail->Password = 'sfajfxfddgdtmoim';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom($emailinp,'gmail');
$mail->addAddress('mitlapiz@gmail.com');
$mail->addReplyTo('mitlapiz@gmail.com');

$mail->isHTML(true);
$mail->Subject = "Contact form";

$mail->Body = 
"<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      line-height: 1.6;
      color: #333333;
    }
    
    h1 {
      color: #0066cc;
    }
    
    .message {
      margin-bottom: 10px;
      color: #000000;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <h1>Subject: " . $messageinp . "</h1>
  <p class='message'>Email: " . $emailinp . "</p>
  <p class='message'>Message: " . $subjectinp . "</p>
</body>
</html>";
// $mail->Body = $emailinp;

if (!$mail -> send()) {
    echo "Messages could not be sent!";
    echo 'Error: ' . $mail->ErrorInfo;
}

else {
    echo "<script>
                Swal.fire({
                  title: 'Message Success!',
                  text: 'Message has been successfully delivered!',
                  icon: 'success',
                }).then(() => {
                    window.open('../../index.php','_self');
                });
                </script>";
	exit();
}
    }
        }
	?>
</body>
</html>
