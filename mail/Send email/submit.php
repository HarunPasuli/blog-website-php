<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
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

$mail->SMTPDebug = 0;
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
"Subject: " . $messageinp . 
"<br>" . "Email: " . $emailinp . 
"<br>" . "Message: " . $subjectinp;
// $mail->Body = $emailinp;

if (!$mail -> send()) {
    echo "Messages could not be sent!";
    echo 'Error: ' . $mail->ErrorInfo;
}

else {
    echo "<script> alert('Message has been sent!') </script>";
    echo "<script> window.open('../../index.php','_self') </script>";
}
    }
        }
?>